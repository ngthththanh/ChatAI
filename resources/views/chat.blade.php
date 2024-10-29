<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Offcanvas | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('theme/assets/images/favicon.ico') }}">

    <!-- glightbox css -->
    <link rel="stylesheet" href="{{ asset('theme/assets/libs/glightbox/css/glightbox.min.css') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('theme/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('theme/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('theme/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('theme/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('theme/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex align-items-center">
                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                aria-controls="offcanvasRight">
                                <i class=" ri-question-answer-line fs-22"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="live-preview">
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                            aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header border-bottom">
                                <h5 class="offcanvas-title" id="offcanvasRightLabel">Chat AI</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="chat-conversation p-3" id="chat-conversation">
                                    <div id="responseBox" class="pb-3">
                                        <!-- Hiển thị thông điệp mặc định nếu không có tin nhắn -->
                                        @if ($chats->isEmpty())
                                            <p class="default-message"
                                                style="text-align: center; color: #999; font-size: 20px; font-weight: bold; font-family: Arial, sans-serif;">
                                                Tôi có thể giúp gì được cho bạn?</p>
                                        @endif

                                        <!-- Vòng lặp tin nhắn người dùng và phản hồi từ hệ thống -->
                                        @foreach ($chats as $chat)
                                            <div class="user-message mb-3"
                                                style="text-align: right; margin-bottom: 10px;">
                                                <span
                                                    style="background-color: #d1e7dd; padding: 8px 12px; border-radius: 15px; display: inline-block; max-width: 300px;">
                                                    {!! nl2br(preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', e($chat->prompt))) !!}
                                                </span>
                                            </div>

                                            <div class="ai-response mb-3" style="margin-bottom: 10px;">
                                                <span
                                                    style="background-color: #f1f1f1; padding: 8px 12px; border-radius: 15px; display: inline-block; max-width: 300px;">
                                                    {!! nl2br(preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', e($chat->response))) !!}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Thanh tải sẽ xuất hiện ở đây khi chờ câu trả lời -->
                                    <div id="loadingSpinner" style="display: none; text-align: center; margin: 10px;"
                                        class="pb-3">
                                        <div class="spinner-border text-dark" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="offcanvas-footer border text-center">
                                <div class="chat-input-section p-4">
                                    <form id="chatinput-form" action="{{ route('store') }}" method="POST">
                                        @csrf
                                        <div class="row g-0 align-items-center">
                                            <div class="col-auto">
                                                <div class="chat-input-links me-2">
                                                    <div class="links-list-item">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                                            id="delete-btn">
                                                            <i class=" ri-delete-bin-5-fill align-middle"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="chat-input-feedback" id="inputFeedback"
                                                    style="display: none;">
                                                    Please Enter a Message
                                                </div>
                                                <input type="text"
                                                    class="form-control chat-input bg-light border-light" id="prompt"
                                                    placeholder="Nhập tin nhắn" name="prompt" autocomplete="off">
                                            </div>
                                            <div class="col-auto">
                                                <div class="chat-input-links ms-2">
                                                    <div class="links-list-item">
                                                        <button type="submit" id="sendBtn"
                                                            class="btn btn-success chat-send waves-effect waves-light"
                                                            disabled>
                                                            <i class="ri-send-plane-2-fill align-bottom"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- container-fluid -->
                </div>
            </div>
        </div>


        <!-- Modal xác nhận xóa -->
        <div class="modal fade" id="confirmDeleteModal" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <lord-icon src="https://cdn.lordicon.com/zpxybbhl.json" trigger="loop"
                            colors="primary:#405189,secondary:#0ab39c" style="width:150px;height:150px">
                        </lord-icon>
                        <div class="mt-3">
                            <h4>Bạn có chắc chắn muốn xóa toàn bộ lịch sử chat không?</h4>
                        </div>
                        <div class="mt-4">
                            <button type="button" class="btn btn-danger" id="confirmDelete">Xóa</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal thông báo thành công -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>

                        <div class="mt-4 pt-3">
                            <h4>Đã xóa thành công lịch sử chat!</h4>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- JAVASCRIPT -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Listen for the offcanvas open event
                const chatOffcanvas = document.getElementById('chatAi');
                chatOffcanvas.addEventListener('shown.bs.offcanvas', function() {
                    // Scroll to the bottom of the chat conversation on open
                    const chatConversation = document.getElementById('chat-conversation');
                    chatConversation.scrollTop = chatConversation.scrollHeight;
                });

            });
        </script>
        <style>
            #chat-conversation {
                height: 550px;
                /* Adjust as needed */
                overflow-y: auto;
            }
        </style>
        <script>
            $(document).ready(function() {
                // Disable the send button initially
                $('#sendBtn').prop('disabled', true);

                // Lắng nghe sự thay đổi trong ô nhập liệu
                $('#prompt').on('input', function() {
                    // Nếu ô nhập trống, disable nút "Gửi"
                    if ($(this).val().trim() === '') {
                        $('#sendBtn').prop('disabled', true);
                    } else {
                        // Nếu có dữ liệu, enable nút "Gửi"
                        $('#sendBtn').prop('disabled', false);
                    }
                });

                $('#chatinput-form').on('submit', function(event) {
                    event.preventDefault(); // Ngăn chặn hành động gửi biểu mẫu mặc định

                    // Lấy giá trị từ ô nhập liệu
                    let prompt = $('#prompt').val();

                    // Nếu ô nhập trống, không làm gì cả
                    if (prompt.trim() === '') {
                        return; // Không hiển thị alert
                    }

                    // Disable nút "Gửi" và ô nhập
                    $('#sendBtn').prop('disabled', true);
                    $('#prompt').prop('disabled', true);

                    // Hiển thị tin nhắn của người dùng
                    $('#responseBox').append(
                        '<div class="user-message" style="text-align: right; margin-bottom: 10px;"><span style="background-color: #d1e7dd; padding: 8px 12px; border-radius: 15px; display: inline-block;">' +
                        prompt + '</span></div>'
                    );

                    // Xóa nội dung trong ô nhập liệu
                    $('#prompt').val('');

                    // Gửi yêu cầu AJAX đến server
                    $.ajax({
                        url: $(this).attr('action'), // URL từ thuộc tính action của form
                        type: 'POST',
                        data: {
                            prompt: prompt,
                            _token: $('input[name="_token"]').val() // Gửi token CSRF
                        },
                        success: function(response) {
                            // Hiển thị phản hồi từ máy chủ
                            const responseText = response.chat.response; // Lấy phản hồi từ JSON

                            // Thay thế các dấu ** bằng chữ in đậm và các ký tự xuống dòng bằng <br>
                            let formattedResponse = responseText.replace(/\*\*(.*?)\*\*/g,
                                '<strong>$1</strong>');
                            formattedResponse = formattedResponse.replace(/\n/g, '<br>');

                            // Hiển thị phản hồi từ hệ thống
                            $('#responseBox').append(
                                `<div class="ai-response" style="margin: 10px 0; padding: 10px; background: #f1f1f1; border-radius: 8px;">${formattedResponse}</div>`
                            );

                            // Cuộn xuống dưới khi có tin nhắn mới
                            $('#chat-conversation').scrollTop($('#chat-conversation')[0]
                                .scrollHeight);

                            // Xóa giá trị input sau khi gửi
                            $('#prompt').val('');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            alert('An error occurred. Please try again.');
                        },
                        complete: function() {
                            // Re-enable nút "Gửi" và ô nhập sau khi yêu cầu hoàn tất
                            $('#sendBtn').prop('disabled', false);
                            $('#prompt').prop('disabled', false);
                        }
                    });
                });
            });
        </script>

        <!-- prismjs plugin -->
        <script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>

        <!-- glightbox js -->
        <script src="{{ asset('theme/assets/libs/glightbox/js/glightbox.min.js') }}"></script>

        <!-- fgEmojiPicker js -->
        <script src="{{ asset('theme/assets/libs/fg-emoji-picker/fgEmojiPicker.js') }}"></script>
        <!-- Bootstrap JS -->
        <script src="{{ asset('theme/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('theme/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('theme/assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('theme/assets/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('theme/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
        <script src="{{ asset('theme/assets/js/plugins.js') }}"></script>
        <!-- App js -->
        <script src="{{ asset('theme/assets/js/app.js') }}"></script>
</body>

</html>
