<div class="row pl-3">
    <h3>Number of Visits</h3>
  </div>

<style>
div.ex1 :hover {
  background-color: #3c4b64;
}
</style>

  <div class="row d-flex justify-content-center">
    <div class="col">
      <a href="{{ route('visitors.searchtoday') }}"><div class="ex1 card text-white bg-primary">
        <div class="card-body">
          <div class="text-muted text-right mb-4">
            <i class="cil-user" style="font-size: 2rem"></i>
          </div>
          <div class="text-value-lg">{{ $visitornow }}</div><small class="text-muted text-uppercase font-weight-bold">Visitors Today</small>
        </div>
      </div></a>
    </div>

    <div class="col">
    <a href="{{ route('visitors.searchbyweek') }}"><div class="ex1 card text-white bg-info">
        <div class="card-body">
          <div class="text-muted text-right mb-4">
            <i class="cil-user" style="font-size: 2rem"></i>
          </div>
          <div class="text-value-lg">{{ $visitorweek }}</div><small class="text-muted text-uppercase font-weight-bold">Visitors this week </small>
        </div>
      </div></a>
    </div>

    

    <div class="col">
    <a href="{{ route('visitors.searchbymonth') }}"><div class="ex1 card text-white bg-warning">
        <div class="card-body">
          <div class="text-muted text-right mb-4">
            <i class="cil-user" style="font-size: 2rem"></i>
          </div>
          <div class="text-value-lg">{{ $visitormonth }}</div><small class="text-muted text-uppercase font-weight-bold">Visitors this month </small>
        </div>
      </div></a>
    </div>

    <div class="col">
    <a href="{{ route('visitors.searchnotallowed') }}"><div class="ex1 card text-white bg-danger">
        <div class="card-body">
          <div class="text-muted text-right mb-4">
            <i class="cil-user" style="font-size: 2rem"></i>
          </div>
          <div class="text-value-lg">{{ $notallowed }}</div><small class="text-muted text-uppercase font-weight-bold">Not Allowed </small>
        </div>
      </div></a>
    </div>


    
    <!-- /.col-->
    <div class="col">
    <a href="{{ route('visitors') }}"><div class="ex1 card text-white bg-success">
        <div class="card-body">
          <div class="text-muted text-right mb-4">
            <i class="cil-user" style="font-size: 2rem"></i>
          </div>
          <div class="text-value-lg">{{ $visitortotal }}</div><small class="text-muted text-uppercase font-weight-bold">Total Visitors</small>
        </div>
      </div></a>
    </div>


    <!-- /.col-->
    
    <!-- /.col-->
    
  </div>