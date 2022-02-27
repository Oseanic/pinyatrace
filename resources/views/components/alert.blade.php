<link rel="stylesheet" href="{{ asset('css/alert.css') }}">

@if (session('message'))
    <div id="message" class="bg-primary">
        <span>{{ session('message') }}</span>
    </div>
@elseif(session('success'))
    <div id="message" class="bg-success">
        <span>{{ session('success') }}</span>
    </div>
@elseif(session('delete'))
    <div id="message" class="bg-danger">
        <span>{{ session('delete') }}</span>
    </div>
@elseif(session('update'))
    <div id="message" class="bg-info">
        <span>{{ session('update') }}</span>
    </div>
@endif

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    $(function() {
        showMessage();
    });

    function showMessage() {
      var m = $("#message");
    
      m.addClass("is-visible");
      setTimeout(function() {
        m.removeClass("is-visible");
        m.addClass("is-hidden");
        setTimeout(function() {
          m.addClass("is-removed");
        }, 2000);
      }, 3000);
    }
</script>