@extends('layouts.main')

@section('content')



<div class=" gap-6">
  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold mb-6">Activity Logs</h1>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">User</th>
                    <th class="border border-gray-300 px-4 py-2">Action</th>
                    <th class="border border-gray-300 px-4 py-2">Description</th>
                    <th class="border border-gray-300 px-4 py-2">IP Address</th>
                    <th class="border border-gray-300 px-4 py-2">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $log->id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $log->user_id ?? 'Guest' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $log->action }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $log->description }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $log->ip_address }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $log->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
  </div>
</div>




@endsection
