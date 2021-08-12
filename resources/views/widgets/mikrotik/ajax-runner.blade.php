<script>
    $(document).ready(function () {
        $.ajax({
            url: '/mikrotik/status',
            type: 'GET',
            error: function() {
                $('#info').html('<p>An error has occurred</p>');
            },
            success: function(data) {
                $('#mikrotik-stats').html(data);
            }
        });
    });
</script>
