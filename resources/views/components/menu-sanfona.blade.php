<div class="mt-2 grid grid-cols-3 gap-x-3">
    <div class="w-full py-3 bg-indigo-200 col-span-1">
        <div class="w-full p-8 mx-auto md:w-3/5">
            <div class="shadow-md">
                <x-menu-admin/>
            </div>
            <button class="w-full p-8 mx-auto font-semibold text-red-700 bg-transparent border border-red-500 rounded md:w-3/52 hover:bg-red-500 hover:text-white hover:border-transparent" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" type="submit">Sair<button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
    </div>
</div>
