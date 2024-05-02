@if(session()->has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire('Pronto', "{{ session('success') }}", 'success')
        })
    </script>
@endif