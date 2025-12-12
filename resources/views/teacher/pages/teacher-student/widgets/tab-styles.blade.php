@section('style')
    <style>
        .form-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .select-start-container,
        .select-end-container {
            width: 100% !important;
        }

        .select2-container {
            z-index: 1050;
        }

        .select2-container .select2-selection--single {
            height: 36px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            line-height: 1.42857143 !important;
            color: #555 !important;
            background-color: #fff !important;
            background-image: none !important;
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            width: 200px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #555 !important;
            line-height: 1.42857143 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 5px !important;
        }

        .slash {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .header-wave {
            background-color: #1A94C8 !important;
            border-radius: 14px;
            position: relative;
            overflow: hidden;
        }

        .header-wave::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 256px;
            background: url("{{ asset('assets/images/wave-header.png') }}");
            background-size: cover;
            opacity: 1;
        }
        .nav-pills .nav-link.active {
            background-color: #098FC6 !important;
            color: #fff !important;
        }

        .nav-pills .nav-link {
            color: #098FC6;
            border-radius: 8px;
        }

        .nav-pills .nav-link:hover {
            background-color: #0A8ABF20;
            color: #098FC6;
        }

        .nav-pills.card {
            border: 1px solid #d6d6d6 !important;
            box-shadow: none !important;
        }


        .nav-pills .nav-link svg path {
            stroke: #098FC6 !important;
            fill: #098FC6 !important;
            transition: 0.2s ease;
        }

        .nav-pills .nav-link.active svg path {
            stroke: #fff !important;
            fill: #fff !important;
        }

        /* .nav-pills .nav-link:hover svg path {
            stroke: #0675a2 !important;
            fill: #0675a2 !important;
        } */


        .btn-custom-year {
            background-color: #169ed7 !important;
            border-color: #169ed7 !important;
            color: white !important;
            border-radius: 10px;
            padding: 10px 18px;
            transition: 0.2s ease;
        }

        .btn-custom-year:hover {
            background-color: #138ec8 !important;
            border-color: #138ec8 !important;
        }

    </style>
    <style>
        .img-background {
            width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            .img-background {
                height: 100px;
            }
        }
    </style>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const studentTab = document.getElementById('pills-students-tab');
        const scheduleTab = document.getElementById('pills-schedule-tab');

        function updateTabStyles(activeTab, inactiveTab) {
            activeTab.classList.remove('btn-outline-primary');
            activeTab.classList.add('btn-primary', 'active');
            
            inactiveTab.classList.remove('btn-primary', 'active');
            inactiveTab.classList.add('btn-outline-primary');
        }

        studentTab.addEventListener('click', function() {
            updateTabStyles(studentTab, scheduleTab);
        });

        scheduleTab.addEventListener('click', function() {
            updateTabStyles(scheduleTab, studentTab);
        });
    });
</script>
