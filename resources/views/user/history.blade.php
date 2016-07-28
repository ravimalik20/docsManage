<div class="row folders_area tableclass">
    @if (isset($histories) && count($histories) > 0)

    <table class="table table-striped">
       <thead>
         <tr>
           <th>Document</th>
           <th>Type</th>
           <th>Status</th>
           <th>Reason</th>
           <th>Uploaded by</th>
           <th>Uploaded at</th>
         </tr>
       </thead>
       <tbody>
         @foreach ($histories as $history)
         <tr>
           <td>{{ $history->filename }}</td>
           <td>{{ $history->type}}</td>
           <td>{{ $history->status}}</td>
           <td>{{ $history->reason}}</td>
           <td>
             @if($history->hasOneUser())
                @if($history->hasOneUser()->id == Auth::user()->id)
                  You
                @else
                    $history->hasOneUser()->name
                @endif
             @endif
           </td>
           <td>{{ $history->created_at}}</td>
         </tr>
         @endforeach
       </tbody>
      </table>

    @else
    <div class="alert alert-info">
        <i class="fa fa-info"></i>
        <p> No history exists.</p>
    </div>
    @endif
</div>
