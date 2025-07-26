<x-perfect-scrollbar
    as="nav"
    aria-label="main"
    class="flex flex-col flex-1 gap-4 px-3"
>
    {{-- =================================================================== --}}
    {{-- ======================== MENU UNTUK ADMIN ========================= --}}
    {{-- =================================================================== --}}
    @role('admin')
        <x-sidebar.link
            title="Dashboard"
            href="{{ route('admin.dashboard') }}"
            :isActive="request()->routeIs('admin.dashboard')"
        >
            <x-slot name="icon">
                <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>

        <x-sidebar.dropdown
            title="Master Data"
            :active="request()->routeIs('admin.barang.*') || request()->routeIs('admin.stok.*')"
        >
            <x-slot name="icon">
                <x-heroicon-o-database class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.sublink
                title="Data Barang"
                href="{{ route('admin.barang.index') }}"
                :active="request()->routeIs('admin.barang.*')"
            />
            <x-sidebar.sublink
                title="Data Stok"
                href="{{ route('admin.stok.index') }}"
                :active="request()->routeIs('admin.stok.*')"
            />
        </x-sidebar.dropdown>

        <x-sidebar.dropdown
            title="Transaksi Gudang"
            :active="request()->routeIs('admin.permintaan.*') || request()->routeIs('admin.pengeluaran.*') || request()->routeIs('admin.inventaris.*')"
        >
            <x-slot name="icon">
                <x-heroicon-o-archive class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.sublink
                title="Permintaan Barang"
                href="{{ route('admin.permintaan.index') }}"
                :active="request()->routeIs('admin.permintaan.*')"
            />
            <x-sidebar.sublink
                title="Pengeluaran Barang"
                href="{{ route('admin.pengeluaran.index') }}"
                :active="request()->routeIs('admin.pengeluaran.*')"
            />
            <x-sidebar.sublink
                title="Stok Opname"
                href="{{ route('admin.inventaris.index') }}"
                :active="request()->routeIs('admin.inventaris.*')"
            />
        </x-sidebar.dropdown>
    @endrole


    {{-- ==================================================================== --}}
    {{-- ======================= MENU UNTUK MANAGER ========================= --}}
    {{-- ==================================================================== --}}
    @role('manager')
        <x-sidebar.link
            title="Dashboard"
            href="{{ route('manager.dashboard') }}"
            :isActive="request()->routeIs('manager.dashboard')"
        >
            <x-slot name="icon">
                <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>

        <x-sidebar.link
            title="Persetujuan Permintaan"
            href="{{ route('manager.persetujuan.index') }}"
            :isActive="request()->routeIs('manager.persetujuan.*')"
        >
            <x-slot name="icon">
                <x-heroicon-o-check-circle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>

        <x-sidebar.dropdown
            title="Laporan"
            :active="request()->routeIs('manager.laporan.*')"
        >
            <x-slot name="icon">
                <x-heroicon-o-document-report class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.sublink
                title="Laporan Stok"
                href="{{ route('manager.laporan.stok') }}"
                :active="request()->routeIs('manager.laporan.stok')"
            />
            <x-sidebar.sublink
                title="Laporan Barang Masuk"
                href="{{ route('manager.laporan.masuk') }}"
                :active="request()->routeIs('manager.laporan.masuk')"
            />
            <x-sidebar.sublink
                title="Laporan Barang Keluar"
                href="{{ route('manager.laporan.keluar') }}"
                :active="request()->routeIs('manager.laporan.keluar')"
            />
        </x-sidebar.dropdown>
    @endrole

</x-perfect-scrollbar>
