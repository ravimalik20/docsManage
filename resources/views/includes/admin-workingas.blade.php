
	{{--*/
                            $non_admin_users = \App\User::nonAdminUsers();
                        /*--}}

 @if (\Session::has("selected_user"))
 @if (count($non_admin_users) > 0)
                                @foreach($non_admin_users as $user)
                                @if (\Session::has("selected_user") && \Session::get("selected_user") == $user->id)
                                      <span style="color: #3c8dbc;vertical-align:middle;font-size:12px;"> <i class="fa fa-user"></i> Working As: {{$user->name}}</span>
                                    @endif
                                @endforeach
                                @endif
                              @else
                                
                            @endif 