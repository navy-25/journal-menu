<script>
    $(document).ready( function () {
        $('#spinner').fadeOut();
        feather.replace()

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));
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

    function pad(s) {
        return (s < 10) ? '0' + s : s;
    }

    function sprintf(n,d) {
        var o = '';
        for (let index = 0; index < (d - n.toString().length); index++) { o+='0'; }
        o+=n;
        return o;
    }
    function dateFormatDate(date) {
        var d = new Date(date);
        if(d.getFullYear() == "1970")
            return "";
        var tmonths = ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"];
        result = pad(d.getDate());
        return result;
    }

    function dateFormatUnYear(date) {
        var d = new Date(date);
        if(d.getFullYear() == "1970")
            return "";
        var tmonths = ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"];
        result = pad(d.getDate()) + " " + tmonths[d.getMonth()+1];
        return result;
    }

    function dateFormat(date) {
        var d = new Date(date);
        if(d.getFullYear() == "1970")
            return "";
        var tmonths = ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"];
        result = pad(d.getDate()) + " " + tmonths[d.getMonth()+1] + " " + d.getFullYear();
        return result;
    }

    function dateNormal(date) {
        var d = new Date(date);
        if(d.getFullYear() == "1970")
            return "";
        result = d.getFullYear()+'-'+pad(d.getMonth())+'-'+pad(d.getDate());
        return result;
    }

    function dateTimeFormat(date) {
        var d = new Date(date);
        if(d.getFullYear() == "1970")
            return "";
        var tmonths = ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"];
        result = pad(d.getDate()) + " " + tmonths[d.getMonth()+1] + " " + d.getFullYear() + " " + d.getHours()+":"+d.getMinutes();
        return result;
    }

    function timeFormat(date) {
        var d = new Date(date);
        if(d.getFullYear() == "1970")
            return "";
        result = d.getHours()+":"+d.getMinutes();
        return result;
    }

</script>
