<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visitors - {{ $dt }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
  </head>

  <style>
      table{
          border-collapse: collapse;
          width: 100%;
      }
      th,td{
          border: 1px solid #ddd;
          text-align:left;
          padding:12px;
      }

      th{
          background-color:#800000;
          color:white;   
      }

      td.nvisit{
        text-align: center;
      }

      h2{
        text-align:center;
        margin: auto;
        width: 60%;
        padding: 10px;
      }

      
  </style>
  
  <body>
  <h2>Visitors - {{ $dt }}</h2>
  
  <table class="table align-items-center table-flush">
                
                <tr class="border" style="color: black">
                    <th>Name</th>
                    <th>Role</th>
                    <th>ID Number</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>

                <tbody>
              @forelse ($visitors as $visitor)
                <tr> 
                    <td>{{ $visitor->res_name }}</td>
                    <td>{{ $visitor->role }}</td>
                    <td>{{ $visitor->id_number }}</td>
                    <td>{{ Carbon\Carbon::parse($visitor->date)->format('M, d Y') }}</td>
                    <td class="{{ $visitor->in === 'Not allowed' ? 'text-danger' : 'text-black'}}">{{ $visitor->in }}</td>               
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="nvisit" colspan="8">No visitors on this date</td>
                </tr>
              @endforelse
            </tbody>
        </table>        
  </body>
</html>