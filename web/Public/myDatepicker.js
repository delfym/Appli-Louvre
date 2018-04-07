

$.fn.datepicker.dates['fr'] = {
    days: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    daysShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
    daysMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
    months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
    monthsShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
    today: "Aujourd'hui",
    clear: "Effacer",
    format: "dd-mm-yyyy",
    titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
    weekStart: 0
};

$('.datepicker').datepicker({
    language: "fr",
    daysOfWeekDisabled: "0,2",
    datesDisabled: ['02-05-2018', '01-11-2018', '25-12-2018', '02-05-2019', '01-11-2019', '25-12-2019']

});
