@extends('voyager::master')
@section('content')
    <h1 class="page-title">
        <i class="fas fa-fingerprint"></i>
        Add Fingerprint
    </h1>
    <div id="voyager-notifications"></div>
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form" class="form-edit-add" action="http://localhost:8000/admin/fingerprints"
                        method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->

                        <!-- CSRF TOKEN -->
                        <input type="hidden" name="_token" value="spXyJq4wCL093biIFhfEpGvw1DCVRQOKHo9bvpTM">

                        <div class="panel-body">


                            <!-- Adding / Editing -->

                            <!-- GET THE DISPLAY OPTIONS -->

                            <div class="form-group   col-md-12 ">
                                <label class="control-label" for="name">Fingerprint Code</label>
                                <input type="text" readonly class="form-control" id="txt_scan" name="fingerprint_code"
                                    placeholder="Fingerprint Code" value="">
                                    <input type="button" id="btn_scan" class='btn btn-primary ' value="Scan" >
                            </div>
                            
                            <!-- GET THE DISPLAY OPTIONS -->

                            <div class="form-group  col-md-12 ">

                                <label class="control-label" for="name">StudentNumber</label>
                                <select class="form-control select2-ajax" name="StudentNumber"
                                    data-get-items-route="http://localhost:8000/admin/fingerprints/relation"
                                    data-get-items-field="fingerprint_belongsto_student_relationship" data-method="add">

                                    <option value="">StudentNumber</option>

                                </select>





                            </div>

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">Save</button>
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="http://localhost:8000/admin/upload" target="form_target" method="post"
                        enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                            onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="fingerprints">
                        <input type="hidden" name="_token" value="spXyJq4wCL093biIFhfEpGvw1DCVRQOKHo9bvpTM">
                    </form>

                </div>
            </div>
        </div>
    </div>

        @stop
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script>
            $(document).ready(function(){
                $('#btn_scan').click(function(){
                    $.ajax({
							type: "POST",
							url: "/api/enroll.php",
							datatype: "json",
							
							success:function(data){
								console.log(data)
								if(data.includes("DONE"))
								{
									let timerInterval
                                    Swal.fire({
                                    title: 'Remove your finger',
                                    html: 'Put again at <b></b> seconds',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    onBeforeOpen: () => {
                                        
                                        Swal.showLoading()
                                        timerInterval = setInterval(() => {
                                        const content = Swal.getContent()
                                        if (content) {
                                            const b = content.querySelector('b')
                                            if (b) {
                                            b.textContent = Math.round(Swal.getTimerLeft()/1000)
                                            }
                                        }
                                        }, 100)
                                    },
                                    onClose: () => {
                                        clearInterval(timerInterval)
                                    }
                                    }).then((result) => {
                                    /* Read more about handling dismissals below */
                                    let timerInterval
                                    Swal.fire({
                                    // title: 'Confirm your fingerpint!!!',
                                    
                                    title: '<center><lottie-player  src="https://assets10.lottiefiles.com/packages/lf20_idfHDi.json"  mode="bounce" background="transparent"  speed="1.2"  style="width: 300px; height: 200px;"  loop  autoplay></lottie-player></center>',
                                    // icon:'info',
                                    html: "<h3>Scan your fingerprint again...</h3>",
                                    timer: 20000,
                                    showClass: {
                                                popup: 'animated jackInTheBox delay-2'
                                            },
                                    // timerProgressBar: true,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                        timerInterval = setInterval(() => {
                                        const content = Swal.getContent()
                                        // if (content) {
                                        // 	const b = content.querySelector('b')
                                        // 	if (b) {
                                        // 	b.textContent = Math.round(Swal.getTimerLeft()/1000)
                                        // 	}
                                        // }
                                        }, 100)
                                    },
                                    onClose: () => {
                                        clearInterval(timerInterval)
                                        // if(data=="done")
                                        // window.location.href = "admin1.php";
                                        // else
                                        // window.location.href = "dashboard.php";
                                    }
                                    }).then((result) => {
                                    /* Read more about handling dismissals below */
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        console.log('I was closed by the timer')
                                    }
                                    })
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        $.ajax({
                                        type: "POST",
                                        url: "/api/enroll2.php",
                                        datatype: "json",
                                        success: function(result){
                                            console.log(result)
                                            if(result.includes("ID"))
                                            {
                                                var ID = result.split(':')
                                                console.log("return ID: " + ID[1])
                                                $("#txt_scan").val(ID[1])
                                                
                                                
                                                Swal.fire(
                                                'Success!',
                                                'Fingerprint Saved!',
                                                'success'
                                                )
                                            }
                                            else{
                                                Swal.fire(
                                                'Error!',
                                                'Fingerprint not matched!',
                                                'error'
                                                )
                                            }
                                        }
                                        })
                                    }
                                    })

								}
								else if(data.includes("not match"))
								{
									Swal.fire({
									title: 'Error',
									text: 'Fingerprint not Match',
									icon: 'error',
									confirmButtonText: 'Okay!'
									}
									)
								}
								else{
									Swal.fire(
									'Error',
									'Problem Communcating with the module',
									'error'
									)
								}
							}
						})





                        let timerInterval
						Swal.fire({
						// title: 'Confirm your fingerpint!!!',
						
						title: '<center><lottie-player  src="https://assets10.lottiefiles.com/packages/lf20_idfHDi.json"  mode="bounce" background="transparent"  speed="1.2"  style="width: 300px; height: 200px;"  loop  autoplay></lottie-player></center>',
						// icon:'info',
						html: "<h3>Scan your fingerprint...</h3>",
						timer: 20000,
						showClass: {
									popup: 'animated jackInTheBox delay-2'
								},
						// timerProgressBar: true,
						onBeforeOpen: () => {
							Swal.showLoading()
							timerInterval = setInterval(() => {
							const content = Swal.getContent()
							// if (content) {
							// 	const b = content.querySelector('b')
							// 	if (b) {
							// 	b.textContent = Math.round(Swal.getTimerLeft()/1000)
							// 	}
							// }
							}, 100)
						},
						onClose: () => {
							clearInterval(timerInterval)
							// if(data=="done")
							// window.location.href = "admin1.php";
							// else
							// window.location.href = "dashboard.php";
						}
						}).then((result) => {
						/* Read more about handling dismissals below */
						if (result.dismiss === Swal.DismissReason.timer) {
							console.log('I was closed by the timer')
						}
						})
            })
                })
           
            
            </script>