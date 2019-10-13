import $ from 'jquery';
import 'autocomplete.js/dist/autocomplete.jquery';
import '../../css/angolia-autocomplete.scss'

$(document).ready(function () {
    $('.js-user-autocomplete').each(function () {
        var autocompleteUrl = $(this).data('autocomplete-url');
        $(this).autocomplete({hint: false}, [
            {
                source: function (query, cb) {
                    cb([
                        {value: 'foo'},
                        {value: 'bar'}
                    ])
                }
            }
        ])
    });
});