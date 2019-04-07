<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

	<link rel="stylesheet" href="assets/css/bootstrap4.css">
	<link rel="stylesheet" href="assets/css/fontawesome.css">
	<link rel="stylesheet" href="assets/css/datatables.css">
    <style>
        .popover.popover-xl { max-width: 400px; }
        .popover-body p { margin-bottom: 0; }
        .btn { transition: 0.5s ease; }
		.badge.badge-xl { font-size: 100%; font-weight: 400; }
    </style>
</head>
<body>
	
	<div class="container">
	  	<div class="row">
		    <div class="col-md-12">
                <h1>An overview of the most common HTTP Status Codes</h1>
				<h3>2xx Success</h3>
				<p>Status codes that indicate that the server successfully processed the request.</p>
				
				<table class="table table-bordered table-hover table-responsive-sm no-footer">
					<thead>
						<tr>
							<th style="width:15%">Status code</th>
							<th style="width:20%">Status message</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><span class="badge badge-success badge-xl">200</span></td>
							<td>OK</td>
							<td>The server successfully processed the request. Generally, this means that the server provided the requested page.</td>
						</tr>
					</tbody>
				</table>

				<h3>3xx Redirection</h3>
				<p>Further action is needed to fulfill the request. Often, these status codes are used for redirection.</p>

				<table class="table table-bordered table-hover table-responsive-sm no-footer">
					<thead>
						<tr>
							<th style="width:15%">Status code</th>
							<th style="width:20%">Status message</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><span class="badge badge-primary badge-xl">300</span></td>
							<td>Multiple Choices</td>
							<td>The server has several actions available based on the request. The server may choose an action based on the requestor (user agent) or the server may present a list so the requestor can choose an action.</td>
						</tr>
						<tr>
							<td><span class="badge badge-primary badge-xl">301</span></td>
							<td>Moved Permanently</td>
							<td>The requested page has been permanently moved to a new location. When the server returns this response, it automatically forwards the requestor to the new location. The response should also include this location. It tells the client to use the new URL the next time it wants to fetch the same resource.</td>
						</tr>
						<tr>
							<td><span class="badge badge-primary badge-xl">302</span></td>
							<td>Moved Temporarily</td>
							<td>The server is currently responding to the request with a page from a different location, but the requestor should continue to use the original location for future requests.</td>
						</tr>
						<tr>
							<td><span class="badge badge-primary badge-xl">304</span></td>
							<td>Not Modified</td>
							<td>The requested page hasn't been modified since the last request. When the server returns this response, it doesn't return the contents of the page.</td>
						</tr>
						<tr>
							<td><span class="badge badge-primary badge-xl">307</span></td>
							<td>Temporary Redirect</td>
							<td>The server is currently responding to the request with a page from a different location, but the requestor should continue to use the original location for future requests. There is very little difference between a 302 status code and a 307 status code. 307 was created as another, less ambiguous, version of the 302 status code.</td>
						</tr>
					</tbody>
				</table>

				<h3>4xx Request error</h3>
				<p>These status codes indicate that there was likely an error in the request which prevented the server from being able to process it.</p>
				
				<table class="table table-bordered table-hover table-responsive-sm no-footer">
					<thead>
						<tr>
							<th style="width:15%">Status code</th>
							<th style="width:20%">Status message</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><span class="badge badge-warning badge-xl">400</span></td>
							<td>Bad Request</td>
							<td>The server didn't understand the syntax of the request.</td>
						</tr>
						<tr>
							<td><span class="badge badge-warning badge-xl">401</span></td>
							<td>Unauthorized</td>
							<td>The request requires authentication, before a resource can be accessed, the client must be authorized by the server. The server might return this response for a page behind a login.</td>
						</tr>
						<tr><td><span class="badge badge-warning badge-xl">403</span></td>
							<td>Forbidden</td>
							<td>The server is refusing the request. Unlike a 401 unauthorized response, authenticating will make no difference.</td>
						</tr>
						<tr>
							<td><span class="badge badge-warning badge-xl">404</span></td>
							<td>Not Found</td>
							<td>The server can't find the requested page. For instance, the server often returns this code if the request is for a page that doesn't exist on the server.</td>
						</tr>
						<tr>
							<td><span class="badge badge-warning badge-xl">410</span></td>
							<td>Gone</td>
							<td>The server returns this response when the requested resource has been permanently removed. It is similar to a 404 (Not found) code, but is sometimes used in the place of a 404 for resources that used to exist but no longer do. If the resource has permanently moved, you should use a 301 to specify the resource's new location.</td>
						</tr>
					</tbody>
				</table>

				<h3>5xx Server error</h3>
				<p>These status codes indicate that the server had an internal error when trying to process the request. These errors tend to be with the server itself, not with the request.</p>
				
				<table class="table table-bordered table-hover table-responsive-sm no-footer">
					<thead>
						<tr>
							<th style="width:15%">Status code</th>
							<th style="width:20%">Status message</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><span class="badge badge-danger badge-xl">500</span></td>							
							<td>Internal Server Error</td>
							<td>The server encountered something it didn't expect and was unable to complete the request.</td>
						</tr>
						<tr>
							<td><span class="badge badge-danger badge-xl">503</span></td>
							<td>Service Unavailable</td>
							<td>The server is currently unavailable (due to a server overload or because it's down for maintenance). Generally, this is a temporary state.</td></tr>
					</tbody>
				</table>
		    </div>
  		</div>
        <div class="results mt-4"></div>
	</div>

	<script src="assets/js/jquery2.2.4.min.js"></script>	
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap4.js"></script>
	<script src="assets/js/fontawesome.js"></script>
	<script src="assets/js/datatables.js"></script>
	<script src="assets/js/validator.js"></script>
</body>
</html>
