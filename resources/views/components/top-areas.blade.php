<h3>{{ $title }}</h3>
<div class="card w-100">
  <div class="table-responsive w-100">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Barangay</th>
          <th scope="col">Number of Active Cases</th>
        </tr>
      </thead>
      <tbody>
       @foreach ($top as $case)
          <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $case->address }}</td>
            <td>{{ $case->count }}</td>
          </tr>
       @endforeach
      </tbody>
    </table>
  </div>
</div>