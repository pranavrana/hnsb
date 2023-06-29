<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>HNSB Report</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css' />
</head>
    <body onload="window.print();">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div>
                        <center>
                            <img src="{{ url('public/assets/images/hnsb sci rec.png') }}" cellpadding="2" width="500px" /><br />
                            <u><strong>Due Fee Student's List</strong></u><br />
                            <table cellpadding="0" width="100%">
                                <tr>
                                    <td align="right">
                                        <font size="2">Academic Year {{ $selectedYear }}</font>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" cellpadding="0" border="1">
                                <thead>
                                    <tr>
                                        <th>Roll No</th>
                                        <th>Gender</th>
                                        <th>Name</th>
                                        <th>Caste</th>
                                        <!-- <th>Admission No</th> -->
                                        <th>GR.No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($students))
                                    @foreach ($students as $key => $s)
                                    <tr>
                                        <td>{{ $s->roll_no }}</td>
                                        <td>{{ $s->user->gender }}</td>
                                        <td>{{ $s->user->name }}</td>
                                        @php
                                            if($s->user->caste == 1):
                                            $cast = 'General';
                                            elseif($s->user->caste == 2):
                                            $cast = 'OBC';
                                            elseif($s->user->caste == 3):
                                            $cast = 'SC';
                                            else:
                                            $cast = 'ST';
                                            endif;
                                        @endphp
                                        <td>{{ $cast }}</td>
                                        <!-- <td>{{ $s->user->admission_no }}</td> -->
                                        <td>{{ $s->user->gr_no }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">No Transaction Found!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </center>
                    </div> <!-- end card body-->
                </div><!-- end col-->
            </div>
        </div> <!-- container -->
    </body>
</html>