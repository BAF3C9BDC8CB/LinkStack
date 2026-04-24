@php
    $modalId = 'qr-contact-modal-' . $link->id;
    $buttonName = str_replace('default ', '', $link->name);
    $iconPath = theme('use_custom_icons') == "true"
        ? url('themes/' . $GLOBALS['themeName'] . '/extra/custom-icons') . '/' . $buttonName . theme('custom_icon_extension')
        : asset('assets/linkstack/icons/' . $buttonName . '.svg');
@endphp

@once
    @push('linkstack-head')
        <style>
            .qr-contact-modal-overlay {
                position: fixed;
                inset: 0;
                display: none;
                align-items: center;
                justify-content: center;
                padding: 24px;
                background: rgba(15, 23, 42, 0.72);
                backdrop-filter: blur(6px);
                z-index: 9999;
            }

            .qr-contact-modal-overlay.is-open {
                display: flex;
            }

            .qr-contact-modal-card {
                width: min(100%, 420px);
                border-radius: 24px;
                background: #ffffff;
                box-shadow: 0 24px 80px rgba(15, 23, 42, 0.28);
                overflow: hidden;
            }

            .qr-contact-modal-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                padding: 20px 22px 12px;
            }

            .qr-contact-modal-title {
                margin: 0;
                color: #0f172a;
                font-size: 1.1rem;
                font-weight: 700;
            }

            .qr-contact-modal-close {
                border: 0;
                background: transparent;
                color: #475569;
                font-size: 1.6rem;
                line-height: 1;
                cursor: pointer;
            }

            .qr-contact-modal-body {
                padding: 8px 22px 24px;
                text-align: center;
            }

            .qr-contact-modal-image {
                display: block;
                width: min(100%, 280px);
                margin: 0 auto;
                border-radius: 18px;
                border: 1px solid #e2e8f0;
                padding: 10px;
                background: #fff;
            }

            .qr-contact-modal-description {
                margin: 16px 0 0;
                color: #475569;
                font-size: 0.95rem;
                line-height: 1.65;
                white-space: pre-line;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.addEventListener('click', function (event) {
                    var trigger = event.target.closest('[data-qr-contact-open]');
                    if (trigger) {
                        event.preventDefault();
                        var targetId = trigger.getAttribute('data-qr-contact-open');
                        var modal = document.getElementById(targetId);
                        if (modal) {
                            modal.classList.add('is-open');
                            document.body.style.overflow = 'hidden';
                        }
                        return;
                    }

                    var closeTrigger = event.target.closest('[data-qr-contact-close]');
                    if (closeTrigger) {
                        var modal = closeTrigger.closest('.qr-contact-modal-overlay');
                        if (modal) {
                            modal.classList.remove('is-open');
                            document.body.style.overflow = '';
                        }
                        return;
                    }

                    if (event.target.classList.contains('qr-contact-modal-overlay')) {
                        event.target.classList.remove('is-open');
                        document.body.style.overflow = '';
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        document.querySelectorAll('.qr-contact-modal-overlay.is-open').forEach(function (modal) {
                            modal.classList.remove('is-open');
                        });
                        document.body.style.overflow = '';
                    }
                });
            });
        </script>
    @endpush
@endonce

<div style="--delay: {{ $initial++ }}s" class="button-entrance">
    <a
        id="{{ $link->id }}"
        class="button button-{{ $link->name }} button-click button-hover icon-hover"
        href="#"
        rel="noopener noreferrer nofollow noindex"
        data-qr-contact-open="{{ $modalId }}"
    >
        <img alt="{{ $link->name }}" class="icon hvr-icon" src="{{ $iconPath }}">
        {{ $link->title }}
    </a>
</div>

<div class="qr-contact-modal-overlay" id="{{ $modalId }}">
    <div class="qr-contact-modal-card" role="dialog" aria-modal="true" aria-labelledby="{{ $modalId }}-title">
        <div class="qr-contact-modal-header">
            <h3 class="qr-contact-modal-title" id="{{ $modalId }}-title">{{ $link->title }}</h3>
            <button type="button" class="qr-contact-modal-close" aria-label="关闭" data-qr-contact-close>&times;</button>
        </div>
        <div class="qr-contact-modal-body">
            <img class="qr-contact-modal-image" src="{{ url($link->qr_image_path) }}" alt="{{ $link->title }} 二维码">
            @if(!empty($link->qr_description))
                <p class="qr-contact-modal-description">{{ $link->qr_description }}</p>
            @endif
        </div>
    </div>
</div>
