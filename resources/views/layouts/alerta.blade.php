<!-- @if (session()->has('succes')) -->
<script type="text/javascript">
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire('Pronto', "{{ session('status_erro') }}", 'success')
        })
    </script>    
<!-- @endif -->