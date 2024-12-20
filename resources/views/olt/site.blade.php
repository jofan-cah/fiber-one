@extends('layouts.main')

@section('content')



<div class=" gap-6">
  <div class="bg-white shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] p-6 max-w-screen-xl mx-auto rounded-lg overflow-hidden">
    <div class="container mx-auto px-4 py-8">

      <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6">OLT Data Table</h1>
        <table id="oltTable" class="display w-full bg-white shadow-md rounded">
          <thead class="bg-gray-200">
            <tr>
              <th>OLT ID</th>
              <th>OLT Name</th>
              <th>Description</th>
              <th>ODPs Count</th>
              <th>ODCs Count</th>
            </tr>
          </thead>
        </table>
      </div>


    </div>
  </div>
</div>



@endsection