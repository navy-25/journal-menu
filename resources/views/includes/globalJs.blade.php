<script>
    $(document).ready( function () {
        $('#spinner').fadeOut();
        feather.replace()
    });
    function alert_confirm(url,title =''){
        Swal.fire({
            title: title+'?',
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }
    function alert(type,title =''){
        Swal.fire({
            title: title,
            icon: type,
        })
    }
</script>
