<div class="text-center">
      <nav>
            <ul class="pagination">
            <?php //$MAX=$pageInfo<=5?$pageInfo:5 ?>
            <?php $MAX=5; $pageInfo= 20; ?>
                  <li><a id="first_page" data-page='{{ $pageInfo }}'>
                        <span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span>
                  </a></li>
                  @for( $i=1 ; $i <= $MAX ; $i++)
                  	@if($i==1)
                  		<li class="active"><a class="page" data-page='{{ $i }}'>{{ $i }}</a></li>
                  	@endif
                        @if($i>1)
                  		<li><a class="page" data-page='{{ $i }}'>{{ $i }}</a></li>
                  	@endif
                  @endfor
                  <li><a id="last_page" data-page='{{ $pageInfo }}'>
                        <span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>
                  </a></li>
            </ul>
      </nav>
</div>