<script type="text/template" id="feed_template">
    <div class="col-8 mt-1 mb-1 offset-2">
        <div class="feed_area row">
            <div class="col-1 feed_header">
                <img src="<%- user.profile %>" width="70">
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <a id="feed-box<%-id %>"></a> <%- user.name %> <small><%=moment(created_at).fromNow()%></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <%=post%>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right">
                <a href="#" class="btn-reply" data-id="<%=id%>">comment</a>
            </div>
        </div>
        <div class="feed_comment_area no-gutters">
            <div class="col-11 offset-1 mt-2 div_reply_feed" id="form_reply<%=id%>">
                <form action="{{ route('formShipCommentFeed') }}" class="form_reply" data-feed="<%=id%>">
                    <label class="mb-0">Write</label>
                    <textarea name="comment" class="form-control"></textarea>
                    <input type="submit" class="btn btn-success mt-1" value="Comment">
                </form>
                <hr>
            </div>
            <%
            const comment_template = _.template($('#feed_comment_template').html())
            _.each(comments, function(object){
            %>
                <%= comment_template(object) %>
                <%
                _.each(object.child_comments, function(child_object){
                %>
                    <%= comment_template(child_object) %>
                <%
                })
                %>
            <%
            })
            %>
        </div>
    </div>
</script>
<script type="text/template" id="feed_comment_template">
    <div class="<%= reply_id ? 'col-10 offset-2' : 'col-11 offset-1' %> mt-1 mb-1 offset-1">

        <div class="feed_area row">
            <div class="col-1 feed_header">
                <img src="<%- user.profile %>" width="70">
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <%- user.name %> <small><%=moment(created_at).fromNow()%></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <%=comment%>
                    </div>
                </div>
            </div>
            <% if(!reply_id){ %>
            <div class="col-12 text-right">
                <a href="#" class="btn-reply" data-id="<%=id%>">comment</a>
            </div>
            <% } %>
        </div>
        <% if(!reply_id){ %>
        <div class="col-11 offset-1 mt-1 div_reply_feed" id="form_reply<%=id%>">
            <form action="{{ route('formShipCommentFeed') }}" class="form_reply" data-feed="<%=feed_id%>" data-parent="<%=id%>">
                <label class="mb-0">Write</label>
                <textarea name="comment" class="form-control"></textarea>
                <input type="submit" class="btn btn-success mt-1" value="Comment">
            </form>
            <hr>
        </div>
        <% } %>
    </div>
</script>