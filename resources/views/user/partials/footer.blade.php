<footer class="bg-dark text-light pt-5">
    <div class="container-fluid px-5">
        <div class="row">
            <!-- Thông tin liên hệ -->
            <div class="col-md-3 col-sm-6">
                <h5>Thông tin liên hệ</h5>
                <ul class="list-unstyled">
                    @if (!empty($settings['contact.email']))
                        <li>
                            <a href="mailto:{{ $settings['contact.email'] }}" class="text-light">
                                Email: {{ $settings['contact.email'] }}
                            </a>
                        </li>
                    @endif
                    @if (!empty($settings['contact.phone']))
                        <li>
                            <a href="" class="text-light">
                                Hotline: {{ $settings['contact.phone'] }}
                            </a>
                        </li>
                    @endif
                    @if (!empty($settings['contact.address']))
                        <li>
                            <a href="" class="text-light">
                                Địa chỉ: {{ $settings['contact.address'] }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <h5>Công ty</h5>
                <ul class="list-unstyled">
                    @foreach ($companyPages as $page)
                        <li>
                            <a href="{{ route('pages.show', $page->slug) }}" class="text-light">
                                {{ $page->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <h5>Pháp lý</h5>
                <ul class="list-unstyled">
                    @foreach ($legalPages as $page)
                        <li>
                            <a href="{{ route('pages.show', $page->slug) }}" class="text-light">
                                {{ $page->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>


            <!-- Mạng xã hội -->
            <div class="col-md-3 col-sm-6">
                <h5>Theo dõi chúng tôi</h5>
                <ul class="list-unstyled d-flex">
                    @if (!empty($settings['social.facebook']))
                        <li class="me-3">
                            <a href="{{ $settings['social.facebook'] }}" class="text-light" target="_blank">
                                <i class="bi bi-facebook"></i>
                            </a>
                        </li>
                    @endif
                    @if (!empty($settings['social.x']))
                        <li class="me-3">
                            <a href="{{ $settings['social.x'] }}" class="text-light" target="_blank">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                        </li>
                    @endif
                    @if (!empty($settings['social.linkedin']))
                        <li class="me-3">
                            <a href="{{ $settings['social.linkedin'] }}" class="text-light" target="_blank">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </li>
                    @endif
                    @if (!empty($settings['social.instagram']))
                        <li class="me-3">
                            <a href="{{ $settings['social.instagram'] }}" class="text-light" target="_blank">
                                <i class="bi bi-instagram"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="text-center mt-4">
            <p>&copy; {{ now()->year }} CourseWeb. Đã đăng ký bản quyền.</p>
        </div>
    </div>
</footer>
