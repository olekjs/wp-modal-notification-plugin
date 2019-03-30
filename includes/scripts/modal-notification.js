jQuery(function($) {
    let $modal = $('.modal');
    $modal.fadeIn();
    $('.close-modal').click(function() {
        $modal.fadeOut();
    });
});