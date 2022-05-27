define(["jquery"], function($) {
    "use strict";
    /**
     * Il timer è generato con Javascript
     * per evitare discrepanze tra <ora_in_cache> e <ora_effettiva>.
     * L'unico input dal blocco php è la timezone del negozio
     * così diamo informazioni accurate a utenti di qualsiasi località.
     */
    return function(config, element) {
        /**
         * DELIVERY_HOUR = int da 0 a 23
         * ora in cui lo store consegna i pacchi al corriere
         */
        const DELIVERY_HOUR = 12;
        /**
         * TIMEZONES
         * mappatura delle timezone magento che usiamo
         * con il delta delle ore rispetto al Greenwich Mean Time
         */
        const TIMEZONES = {
            "Europe/Rome": 2, // GMT/UTC + 2h (ora legale)
            "Africa/Casablanca": 1, // GMT/UTC + 1h
            /* ... */
            "Africa/El_Aaiun": 1, // alternativa per GMT/UTC + 1h
            "America/Dawson": -7 // GMT -7h
        };
        /**
         * ora attuale (rispetto al negozio)
         */
        let store_date = new Date();
        const TIME_OFFSET = TIMEZONES[config.timezone] * 3600000; //3600000 millis = 1 ora
        store_date.setTime(store_date.getTime() + TIME_OFFSET);
        /**
         * prossima deadline ora consegne (rispetto al negozio)
         */
        let deadline = new Date(store_date);
        deadline.setUTCHours(DELIVERY_HOUR, 0, 0);
        if (store_date.getUTCHours() >= DELIVERY_HOUR) {
            deadline.setTime(deadline.getTime() + 86400000); //86400000 millis = 1 giorno
        }
        /**
         * differenza tra ora attuale e la prossima deadline
         */
        const time_left = (deadline.getTime() - store_date.getTime()) / 60000;
        const hours_left = Math.floor(time_left / 60);
        const minutes_left = Math.floor(time_left % 60);
        const DAY = deadline.getUTCDay();
        const max_hours = 12;
        const min_minutes = 5;
        if (DAY != 0 /*Domenica*/ &&
            DAY != 6 /*Sabato*/ &&
            hours_left <= max_hours /*range di ore in cui visualizzare il messaggio*/ &&
            time_left >= min_minutes /*range di minuti in cui visualizzare il messaggio*/ ) {
            	const hours_left_text = hours_left != 0 ? (`${hours_left} or${hours_left==1?'a':'e'} e `) : ``;
            	element.innerText = `Ordina entro ${hours_left_text}${minutes_left} minut${minutes_left==1?'o':'i'} per ricevere i tuoi prodotti domani`;
		element.classList.add("urgency");
        }
        /*
		//istruzioni usate per il debug
        console.log(store_date.toLocaleString('en-GB', { timeZone: 'UTC', timeZoneName: 'short' }));
        console.log(deadline.toLocaleString('en-GB', { timeZone: 'UTC', timeZoneName: 'short' }));
        console.log(time_left);
        console.log(hours_left);
        console.log(minutes_left);
        console.log(TIME_OFFSET);
        console.log(config.timezone + ": " + TIMEZONES[config.timezone]);
		*/
    }
})
