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
    </style>
</head>
<body>
	
	<div class="container">
	  	<div class="row">
		    <div class="col-md-12">
                <div class="form-group">
                    <label for="urls_box"> Enter urls</label>
                    <textarea class="form-control" id="urls_box" rows="10"></textarea>
                </div>
		    	<button id="submit_btn" class="btn btn-primary"><span class="loading">Submit</span><span class="loading" style="display: none;">Submitting</span> <i class="fa fa-paper-plane loading"></i> <span class="loading" style="display: none;"><i class="fas fa-spinner fa-spin"></i></span></button>		    	
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
	<script>

		var user_agents = {
			browser: {
				name:'',
				value: ''
			},
			bots: {
				0: {
					name:'Googlebot/2.1',
					value: 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'
				},
				1: {
					name:'Googlebot/2.1 (Smartphone)',
					value: 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'
				},
				2: {
					name:'Googlebot-Mobile/2.1 (Feature phone)',
					value: 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'
				},

				3: {
					name:'Bingbot/2.0',
					value: 'Mozilla/5.0 (compatible; Bingbot/2.0; +http://www.bing.com/bingbot.htm)'
				},
				4: {
					name:'Yahoo! Slurp',
					value: 'Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)'
				},
				5: {
					name:'Bingbot/2.0',
					value: 'Mozilla/5.0 (compatible; Bingbot/2.0; +http://www.bing.com/bingbot.htm)'
				},
				6: {
					name:'DuckDuckBot',
					value: 'DuckDuckBot/1.0; (+http://duckduckgo.com/duckduckbot.html)'
				},
				7: {
					name:'Baiduspider/2.0',
					value: 'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)'
				},
				8: {
					name:'YandexBot/3.0',
					value: 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'
				},
			}
		};
    	$('#submit_btn').on('click', function() {
    		$(this).prop('disabled', true);
    		var $this = $(this);
    		$('.loading').toggle();
    		var all_urls = $.trim($('#urls_box').val());
    		if (all_urls != '') {
                $('.table').remove();
    			$.ajax({
    				type: 'POST',
    				method: 'POST',
    				url: 'http://localhost/jstest/check_url.php',
    				data: {
    					all_urls : all_urls
    				},
    				success: function(resp) {
                        resp = JSON.parse(resp);
    					console.log(resp);
                        var html = [];

                        if (resp.length > 0) {
                            html.push('<table id="tableToGrid" class="table table-bordered table-hover table-responsive-sm"><thead class="thead-light"><tr><th>Url</th><th>Status</th><th>Redirects</th></tr></thead>');
                            for (idx in resp) {
                            	var redirect_count = 0;
                                console.log(idx, resp[idx]);  
                                html.push('<tr><td>'+resp[idx].url+'</td><td>');        
                                for (m in resp[idx].header) {
                                    for (n in resp[idx].header[m]){
                                    	var tooltip_html = [];
	                                    for(o in resp[idx].header[m].header_details) {
	                                        tooltip_html.push(escapeHtml('<p><strong>'+resp[idx].header[m].header_details[o].name +':</strong> '+resp[idx].header[m].header_details[o].details+'</p>'));
	                                    }                                     	
                                    }
                                    var status_code = resp[idx].header[m].status;
                                    var status_class = '';

                                    switch(status_code) {
									    case 200:
									        status_class = 'success'; break;
									    case 301:
									        status_class = 'primary'; break;
									    case 302:
									        status_class = 'primary'; break;
									    case 403:
									        status_class = 'warning'; break;
									    case 404:
									        status_class = 'warning'; break;
									    default:
									        status_class = 'danger';
									}

                                    html.push('<span class="badge badge-' + status_class + ' badge-trigger" data-toggle="popover" data-title="'+resp[idx].header[m].title+'" data-color="'+status_class+'" data-content="'+tooltip_html.join('')+'">'+resp[idx].header[m].status+'</span>');   
                                    if (m < resp[idx].header.length - 1) {
                                        html.push(' <i class="fas fa-long-arrow-alt-right"></i> ');
                                    }
                                }
                                html.push('</td><td>'+(resp[idx].header.length - 1) +'</td></tr>');
                            }   
                            $('.results').empty().html(html.join(''));
                            $('.badge-trigger').each(function(index){ 
                                $(this).popover({
                                    html: true,
                                    trigger: 'hover',
                                    template: '<div class="popover popover-xl" role="tooltip"><div class="arrow"></div><h3 class="popover-header bg-' + $(this).attr('data-color') + ' text-white"></h3><div class="popover-body"></div></div>'
                                });
                            });
                            $('#tableToGrid').DataTable();
                        }
                        $this.removeAttr('disabled');            
    					$('.loading').toggle();
                        //$('[data-toggle="popover"]').popover();
    				}
    			});
    		} else {
    			$this.removeAttr('disabled');
    			$('.loading').toggle();
    		}
    	});
        
        function escapeHtml(unsafe) {
            return unsafe
                 .replace(/&/g, "&amp;")
                 .replace(/</g, "&lt;")
                 .replace(/>/g, "&gt;")
                 .replace(/"/g, "&quot;")
                 .replace(/'/g, "&#039;");
         }
    </script>       
</body>
</html>
