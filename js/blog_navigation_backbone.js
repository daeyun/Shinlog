$(document).ready(function(){
	window.App = new Shinlog();
	Backbone.history.start();
});
(function() {
	window.Post = Backbone.Model.extend({});
	window.Posts = Backbone.Collection.extend({
		model: Post,
	});
	window.library = new Posts();
	window.post = new Post();
	window.PostView = Backbone.View.extend({
		template: "#post",
		model:window.post,
		initialize: function() {
			_.bindAll(this, 'render');
			this.template = _.template($(this.template).html());
			this.collection.bind('reset',this.render);
		},
		render: function() {
			$('.posts').empty();
			template=this.template;
			$(".posts").hide(0,function(){
				$(".posts").fadeTo(50,0,function(){
					$(".posts").fadeTo(550,1);
				});
			});
			this.collection.each(function(post){
				$(".posts").append(this.template(post.toJSON()));
			});
		}
	});
	function getPosts(page){
		window.library.url="json/blog-page/"+page;
		window.library.fetch();
		$(".blognav .olderposts").hide(0);
		$.get("json/blog-navbutton/"+page, function(data){
			$(".blognav .olderposts").attr("href","#"+(parseInt(page)+1)).show(0);
		});
		if(parseInt(page)<="1"){
			$(".blognav .newerposts").hide(0);
		}else{
			$(".blognav .newerposts").attr("href","#"+(parseInt(page)-1)).show(0);
		}
	}
	window.Shinlog = Backbone.Router.extend({
		routes: {
			'*page':'default',
		},
		initialize: function(){
			window.postview = new PostView({
				collection: window.library
			});
		},
		default: function(page){
			if(page!=""){
			getPosts(page);
			}
		},
	});
})(jQuery);
