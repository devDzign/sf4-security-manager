import $ from 'jquery'

$(document).ready(function () {
    $('.love').on('click', function (e) {
        e.preventDefault();
        var $link = $(e.currentTarget);
        $link.toggleClass('fa-heart-o').toggleClass('fa-heart')
    })

})
