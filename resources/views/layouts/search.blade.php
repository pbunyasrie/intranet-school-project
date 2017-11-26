
    <!-- START SEARCH -->
	<div class="content">
		<div class="columns is-mobile">
			<div class="column is-10">
			    <form id="elasticScout" action="{{ route('search') }}" method="get">
				    <div class="field has-addons">
				      <div class="control has-icons-left">
				        <input class="input is-large" name="query" type="text" value="@if(!empty($query)){{ $query }}@endif" placeholder="Find a file or folder...">
				        <span class="icon is-medium is-left">
				          <i class="fa fa-search"></i>
				        </span>
				      </div>
				      <div class="control">
					      <button class="button is-large is-info">
					      	Search
					      </button>
				  	  </div>
			  	 	</div>
			    </form>

			 </div>
			 <div class="column is-2" style="margin-top: 10px">
		        <a class="button is-warning" href="{{ route('help') }}">
		            <i class="fa fa-question"></i> 
		        </a>
		     </div>
		</div>
	</div>
    <!-- END SEARCH -->
