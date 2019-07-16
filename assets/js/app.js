require('../css/app.css');
const $ = require('jquery');
import 'bootstrap';
import 'jquery-ui/ui/widgets/datepicker.js';
import './add-collection-widget.js';


require('@fortawesome/fontawesome-free/css/all.min.css');

$( function() {



    $( ".js-datepicker" ).datepicker(
        {
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            yearRange: "-0:+1"
        }
    );

} );