@extends('layouts.admin')

@section('content')

<style>
    body{
        background: #050505;
    }

    .service-container{
        max-width: 1350px;
        margin: 40px auto;
        padding: 10px;
    }

    .service-title{
        font-size: 60px;
        color: #e2bd72;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 30px;
    }

    .top-action{
        margin-bottom: 35px;
    }

    .btn-add{
        display: inline-block;
        background: #e2bd72;
        color: #111;
        text-decoration: none;
        padding: 18px 32px;
        border-radius: 16px;
        font-size: 20px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-add:hover{
        background: #f0cc84;
    }

    .alert-success{
        background: #16311f;
        color: #7dffb1;
        padding: 18px 22px;
        border-radius: 14px;
        margin-bottom: 25px;
        font-weight: 600;
    }

    .table-wrapper{
        background: #0c0907;
        border: 1px solid #2e231c;
        border-radius: 28px;
        overflow: hidden;
    }

    table{
        width: 100%;
        border-collapse: collapse;
    }

    thead{
        background: #211912;
    }

    thead th{
        color: #fff;
        text-align: left;
        padding: 28px 22px;
        font-size: 18px;
    }

    tbody td{
        padding: 28px 22px;
        color: white;
        border-top: 1px solid #1f1712;
        font-size: 17px;
        font-weight: 500;
    }

    tbody tr:hover{
        background: #120f0d;
    }

    .price{
        color: #e2bd72;
        font-weight: bold;
    }

    .duration-badge{
        display: inline-block;
        padding: 10px 16px;
        border-radius: 999px;
        background: #2b211a;
        color: #f0c879;
        border: 1px solid #5c4632;
        font-size: 14px;
        font-weight: bold;
    }

    .action-group{
        display: flex;
        gap: 12px;
    }

    .btn-edit,
    .btn-delete{
        border: none;
        padding: 12px 22px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-edit{
        background: #262321;
        color: #ffd28a;
        border: 1px solid #49423c;
    }

    .btn-edit:hover{
        background: #332f2b;
    }

    .btn-delete{
        background: #2a1412;
        color: #ffb4a5;
        border: 1px solid #5f2c26;
    }

    .btn-delete:hover{
        background: #3a1b18;
    }

    .empty-data{
        text-align: center;
        padding: 50px;
        color: #aaa;
        font-size: 18px;
    }
</style>

<div class="service-container">

    <h1 class="service-title">
        Services Salon
    </h1>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="top-action">
        <a href="{{ route('admin.services.create') }}" class="btn-add">
            + Tambah Service
        </a>
    </div>

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($services as $service)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $service->name }}
                        </td>

                        <td>
                            {{ $service->description }}
                        </td>

                        <td class="price">
                            Rp {{ number_format($service->price, 0, ',', '.') }}
                        </td>

                        <td>
                            <span class="duration-badge">
                                {{ $service->duration }} Minutes
                            </span>
                        </td>

                        <td>

                            <div class="action-group">

                                <a href="{{ route('admin.services.edit', $service->id) }}"
                                   class="btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('admin.services.destroy', $service->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus service ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-delete">
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="empty-data">
                            Belum ada service salon
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection