
    <!-- START SEARCH -->
	<div class="content">
		<div class="columns is-mobile">
			<div class="column is-9">
			    <form id="elasticScout" action="{{ route('search') }}" method="get">
			      <div class="control has-icons-left has-icons-right">
			        <input class="input is-large" name="query" type="text" value="@if(!empty($query)){{ $query }}@endif" placeholder="Search...">
			        <span class="icon is-medium is-left">
			          <i class="fa fa-search"></i>
			        </span>
			      </div>
			    </form>

			 </div>
			 <div class="column is-3" style="margin-top: 10px">
		        <a class="button is-warning" href="{{ route('help') }}">
		            Help
		        </a>
		     </div>
		</div>
	</div>
    <!-- END SEARCH -->
