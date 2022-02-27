<div class="visible-print text-center mb-3" id="target">
                  {!! QrCode::size(200)->generate(route(('view'))); !!}
</div>

<div class="visible-print text-center mb-3">
                  {!! QrCode::color(255, 0, 0)->size(200)->generate(route(('view'))); !!}
</div>