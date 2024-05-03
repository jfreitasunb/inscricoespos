@if(session()->has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire('Pronto', "{{ session('success') }}", 'success')
        })
    </script>
@endif

@if(session()->has('erro_configura_edital'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire('Pronto', "{{ session('erro_configura_edital') }}", 'error')
        })
    </script>
@endif
