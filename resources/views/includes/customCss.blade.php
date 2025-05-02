<style>
    html,body{
        font-family: 'Open Sans', sans-serif !important;
    }
    body {
        background: rgb(235, 235, 235);
    }
    .bg-body {
        background: rgb(235, 235, 235) !important;
    }
    .bg-body-blur {
        background: rgba(235, 235, 235, 0.397) !important;
        backdrop-filter: blur(10px);
    }
    .bg-warning {
        background-color: #ff5e00 !important;
    }
    .bg-light-warning {
        background-color: #ff5e001a !important;
    }
    .bg-light-success {
        background-color: #1987541c !important;
    }
    .text-warning {
        color: #ff5e00 !important;
    }
    .btn-warning {
        --bs-btn-color: #ffffff;
        --bs-btn-bg: #ff5e00;
        --bs-btn-border-color: #ff5e00;
        --bs-btn-hover-color: #ffffff;
        --bs-btn-hover-bg: #d85910;
        --bs-btn-active-color: #ffffff;
        --bs-btn-active-bg: #d85910;
        --bs-btn-disabled-color: #ffffff;
        --bs-btn-disabled-bg: #ff9355;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }
    .form-control{ height: 50px !important; }
    .form-control:focus{
        outline: 1px solid #ff5e00 !important;
        box-shadow: none !important;
    }
    .form-select:focus {
        border-color: #00000018 !important;
        outline: 0 !important;
        box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 0%) !important;
    }
    .swal2-container.swal2-backdrop-show, .swal2-container.swal2-noanimation { background: rgb(0 0 0 / 71%) !important; }
    .swal2-styled.swal2-confirm {
        background-color: #323232 !important;
        border-radius: 15px !important;
    }
    .swal2-styled.swal2-confirm:focus, .swal2-styled.swal2-cancel:focus { box-shadow: 0 0 0 3px rgb(112 102 224 / 0%) !important; }
    .swal2-styled.swal2-cancel {
        background-color: #ffffff00 !important;
        color: #3c3c3c !important;
        border-radius: 15px !important;
    }
    .swal2-actions:not(.swal2-loading) .swal2-styled:hover { background-image: linear-gradient(rgb(0 0 0 / 4%), rgb(0 0 0 / 4%)) !important; }
    .swal2-popup {
        width: 300px !important;
        padding: 20px !important;
        border-radius: 30px !important;
    }
    .form-control:focus {
        border-color: #3a3a3a38 !important;
        box-shadow: 0 0 0 0.25rem rgb(98 98 98 / 0%) !important;
    }
    .swal2-title {
        font-size: 1.3em !important;
        padding: 25px 0px !important;
    }
    .bg-light-dark{
        background: rgba(43, 43, 43, 0.1) !important;
        color: rgb(43, 43, 43) !important;
    }
    /* .bg-light-warning{
        background: rgba(255, 138, 4, 0.1) !important;
        color: rgb(255, 155, 4) !important;
    } */
    .bg-light-danger{
        background: rgba(255, 12, 4, 0.1) !important;
        color: rgb(199, 49, 49) !important;
    }
    .shadow{ box-shadow: 0px 30px 50px !important; }
    .shadow-mini{ box-shadow: 0px 0px 30px rgba(58, 58, 58, 0.144) }
    .modal-dialog-bottom{
        position: fixed !important;
        margin: 0px !important;
        width: 100% !important;
        bottom: 0px !important;
    }
    .modal-content-bottom.vw-100{ border-radius: 20px 20px 0px 0px !important; }
    .rounded-5{ border-radius: 15px !important }
    /* spinner */
    @media screen and (min-width: 768px) {
        #spinner,
        #nav-bottom,
        #nav-bottom-custom,
        #reminder,
        #nav-top,
        /* .modal, */
        .swal2-container,
        #button-create {
            max-width: 450px !important;
            margin: 0 auto !important;
        }
    }
    #spinner{
        position: fixed;
        z-index: 9999999;
        height: 100vh;
        width: 100%;
        background: white !important;
        /* backdrop-filter: blur(10px); */
        /* background: rgba(73, 73, 73, 0.5); */
        padding-top: 40vh
    }
    .form-select{ padding: 15px !important; }
    .text-gray{ color : #21252994 !important; }
    .fs-7{ font-size: 12px  !important; }
    a{ cursor: pointer !important; }

    .text-small {
        font-size: .85rem !important;
    }
    .text-bg-warning {
        /* color: #000 !important; */
        background-color: #ff5e00 !important;
    }
    .progress {
        border-radius: 20px;
        background-color: #ff5e001a !important;
    }
    .progress.bg-warning {
        border-radius: 20px;
        background-color: #ff5e00 !important;
    }
</style>
