<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
        .dbox {
            position: relative;
            background: rgb(255, 86, 65);
            background: -moz-linear-gradient(top, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
            background: -webkit-linear-gradient(top, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
            background: linear-gradient(to bottom, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
            filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#ff5641', endColorstr='#fd3261', GradientType=0);
            border-radius: 4px;
            text-align: center;
            margin: 60px 0 50px;
        }

        .dbox__icon {
            position: absolute;
            transform: translateY(-50%) translateX(-50%);
            left: 50%;
        }

        .dbox__icon:before {
            width: 75px;
            height: 75px;
            position: absolute;
            background: #fda299;
            background: rgba(253, 162, 153, 0.34);
            content: '';
            border-radius: 50%;
            left: -17px;
            top: -17px;
            z-index: -2;
        }

        .dbox__icon:after {
            width: 60px;
            height: 60px;
            position: absolute;
            background: #f79489;
            background: rgba(247, 148, 137, 0.91);
            content: '';
            border-radius: 50%;
            left: -10px;
            top: -10px;
            z-index: -1;
        }

        .dbox__icon>i {
            background: #ff5444;
            border-radius: 50%;
            line-height: 40px;
            color: #FFF;
            width: 40px;
            height: 40px;
            font-size: 22px;
        }

        .dbox__body {
            padding: 50px 20px;
        }

        .dbox__count {
            display: block;
            font-size: 30px;
            color: #FFF;
            font-weight: 300;
        }

        .dbox__title {
            font-size: 13px;
            color: #FFF;
            color: rgba(255, 255, 255, 0.81);
        }

        .dbox__action {
            transform: translateY(-50%) translateX(-50%);
            position: absolute;
            left: 50%;
        }

        .dbox__action__btn {
            border: none;
            background: #FFF;
            border-radius: 19px;
            padding: 7px 16px;
            text-transform: uppercase;
            font-weight: 500;
            font-size: 11px;
            letter-spacing: .5px;
            color: #003e85;
            box-shadow: 0 3px 5px #d4d4d4;
        }

        .dbox--color-2 {
            background: rgb(252, 190, 27);
            background: -moz-linear-gradient(top, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
            background: -webkit-linear-gradient(top, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
            background: linear-gradient(to bottom, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
            filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#fcbe1b', endColorstr='#f85648', GradientType=0);
        }

        .dbox--color-2 .dbox__icon:after {
            background: #fee036;
            background: rgba(254, 224, 54, 0.81);
        }

        .dbox--color-2 .dbox__icon:before {
            background: #fee036;
            background: rgba(254, 224, 54, 0.64);
        }

        .dbox--color-2 .dbox__icon>i {
            background: #fb9f28;
        }

        .dbox--color-3 {
            background: rgb(183, 71, 247);
            background: -moz-linear-gradient(top, rgba(183, 71, 247, 1) 0%, rgba(108, 83, 220, 1) 100%);
            background: -webkit-linear-gradient(top, rgba(183, 71, 247, 1) 0%, rgba(108, 83, 220, 1) 100%);
            background: linear-gradient(to bottom, rgba(183, 71, 247, 1) 0%, rgba(108, 83, 220, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b747f7', endColorstr='#6c53dc', GradientType=0);
        }

        .dbox--color-3 .dbox__icon:after {
            background: #b446f5;
            background: rgba(180, 70, 245, 0.76);
        }

        .dbox--color-3 .dbox__icon:before {
            background: #e284ff;
            background: rgba(226, 132, 255, 0.66);
        }

        .dbox--color-3 .dbox__icon>i {
            background: #8150e4;
        }

        /* Modal styles */
        .profile-modal .modal-content {
            border-radius: 8px;
        }

        .profile-modal .modal-header {
            background: linear-gradient(to bottom, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
            color: white;
            border-radius: 8px 8px 0 0;
        }

        .profile-info {
            padding: 20px;
        }

        .profile-info p {
            margin: 10px 0;
            font-size: 16px;
        }

        .profile-info label {
            font-weight: bold;
            min-width: 120px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="dbox dbox--color-1">
                    <div class="dbox__icon">
                        <i class="glyphicon glyphicon-cloud"></i>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
                    </div>
                    <div class="dbox__body">
                        <span class="dbox__count">8,252</span>
                        <span class="dbox__title">Profile</span>
                    </div>
                    <div class="dbox__action">
                        <button class="dbox__action__btn" data-toggle="modal" data-target="#profileModal">More Info</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dbox dbox--color-2">
                    <div class="dbox__icon">
                        <i class="glyphicon glyphicon-download"></i>
                    </div>
                    <div class="dbox__body">
                        <span class="dbox__count">100</span>
                        <span class="dbox__title">Outstanding Balance</span>
                    </div>
                    <div class="dbox__action">
                        <button class="dbox__action__btn">More Info</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dbox dbox--color-3">
                    <div class="dbox__icon">
                        <i class="glyphicon glyphicon-heart"></i>
                    </div>
                    <div class="dbox__body">
                        <span class="dbox__count">2502</span>
                        <span class="dbox__title">Recent transaction</span>
                    </div>
                    <div class="dbox__action">
                        <button class="dbox__action__btn">More Info</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="modal fade profile-modal" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="profileModalLabel">Student Profile</h4>
                </div>
                <div class="modal-body">
                    <div class="profile-info">
                        <p><label>Student ID:</label> ST123456</p>
                        <p><label>Name:</label> John Doe</p>
                        <p><label>Program:</label> Bachelor of Science in Computer Science</p>
                        <p><label>Year Level:</label> 3rd Year</p>
                        <p><label>Email:</label> john.doe@university.edu</p>
                        <p><label>Phone:</label> (555) 123-4567</p>
                        <p><label>Address:</label> 123 University Ave, College Town, ST 12345</p>
                        <p><label>Status:</label> Active</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
$(document).ready(function() {
    // When the More Info button is clicked
    $('.dbox__action__btn[data-target="#profileModal"]').on('click', function() {
        // Fetch the student profile data
        $.ajax({
            url: '<?= site_url('student/getProfile') ?>', // Using CI4's site_url helper
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'  // Required for CI4 AJAX
            },
            success: function(data) {
                // Update the modal content with the fetched data
                $('.profile-info').html(`
                    <p><label>Student ID:</label> ${data.matricNum || 'N/A'}</p>
                    <p><label>Name:</label> ${data.name || 'N/A'}</p>
                    <p><label>Program:</label> ${data.program || 'N/A'}</p>
                    <p><label>Year Level:</label> ${data.yearLevel || 'N/A'}</p>
                    <p><label>Email:</label> ${data.email || 'N/A'}</p>
                    <p><label>Phone:</label> ${data.phone || 'N/A'}</p>
                    <p><label>Address:</label> ${data.address || 'N/A'}</p>
                    <p><label>Status:</label> ${data.status || 'Active'}</p>
                `);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching profile:', error);
                alert('Error loading profile data. Please try again.');
            }
        });
    });
});
</script>
</body>

</html>