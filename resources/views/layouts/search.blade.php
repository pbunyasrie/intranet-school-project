
    <!-- START SEARCH -->
	<div class="content">
	    <form id="elasticScout" action="{{ route('search') }}" method="get">
	      <div class="control has-icons-left has-icons-right">
	        <input class="input is-large" name="query" type="text" value="@if(!empty($query)){{ $query }}@endif" placeholder="Search...">
	        <span class="icon is-medium is-left">
	          <i class="fa fa-search"></i>
	        </span>
	      </div>
	    </form>
	</div>
    <!-- END SEARCH -->
