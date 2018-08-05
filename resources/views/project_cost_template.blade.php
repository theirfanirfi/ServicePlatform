<script type="text/template" id="project_cost_template">
    <div class="col-6 mt-2 mb-2">
        <div class="card">
            <div class="p-2 bg-light">
                <h5 class="card-title text-center mb-0 text-uppercase"><%-name%></h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col text-center">Quantity: <%- quantity %></div>
                        <div class="col text-center">Amount: <%- amount %></div>
                        <div class="col-12 text-center"><small><%-moment(created_at).fromNow()%></small></div>
                    </div>
                </li>
            </ul>
            <%
                var bg_color = '';
                if (status === 1) {
                    bg_color = 'bg-success';
                }else if(status === 2){
                    bg_color = 'bg-warning';
                }
            %>

            <div class="p-2 <%-bg_color%>">
                <div class="row">
                    @if($project->user->id === auth()->user()->id)
                        <% if (status === 0) { %>
                            <div class="col-6 offset-3 text-center"><a href="#" data-cost="<%-id%>" class="btn-cost-remove card-link btn btn-danger btn-sm form-control">Remove</a></div>
                        <% }else if(status === 0){ %>
                            <div class="col-6 offset-3 text-center">
                                <% if (status === 1) { %>
                                <span class="badge badge-success">ACCEPTED</span>
                                <% }else{ %>
                                <span class="badge badge-warning">DECLINED</span>
                                <% } %>
                            </div>
                        <% } %>
                    @else
                        <% if (project.invitations.length && status === 0) { %>
                            <div class="col text-left"><a href="#" data-type="1" data-cost="<%-id%>" class="btn-cost-action card-link btn btn-success btn-sm form-control">Accept</a></div>
                            <div class="col text-right"><a href="#" data-type="2" data-cost="<%-id%>" class="btn-cost-action card-link btn btn-default btn-sm form-control">Decline</a></div>
                        <% }else{ %>
                            <div class="col-6 offset-3 text-center">
                                <% if (status === 1) { %>
                                <span class="badge badge-success">ACCEPTED</span>
                                <% }else{ %>
                                <span class="badge badge-warning">DECLINED</span>
                                <% } %>
                            </div>
                        <% } %>
                    @endif
                </div>
            </div>
        </div>
    </div>
</script>