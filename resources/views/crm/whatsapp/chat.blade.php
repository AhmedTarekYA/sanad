@extends('crm.layout')

@section('page-title', __('whatsapp_chat'))

@section('style')
    <style>
        :root {
            --wb-green: #00a884;
            --wb-green-dark: #008069;
            --wb-bg: #f0f2f5;
            --wb-panel: #ffffff;
            --wb-border: rgba(0, 0, 0, 0.08);
            --wb-muted: rgba(0, 0, 0, 0.55);
            --wb-text: rgba(0, 0, 0, 0.88);
            --wb-chat-bg: #efeae2;
            --wb-in-msg: #ffffff;
            --wb-out-msg: #d9fdd3;
        }

        #whats-chat-root {
            min-height: 75vh;
        }

        .wb-inbox {
            display: flex;
            height: 78vh;
            background: var(--wb-bg);
            border: 1px solid var(--wb-border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        }

        body.wb-chat-expanded {
            overflow: hidden !important;
        }

        .wb-inbox.is-expanded {
            position: fixed !important;
            inset: 0 !important;
            z-index: 1060;
            width: 100vw !important;
            max-width: none !important;
            height: 100dvh !important;
            min-height: 0 !important;
            margin: 0 !important;
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        .wb-inbox.is-expanded .wb-chat,
        .wb-inbox.is-expanded .wb-sidebar {
            height: 100%;
        }

        .wb-chat-resize-btn .fa-compress {
            display: none;
        }

        .wb-chat-resize-btn.is-expanded .fa-expand {
            display: none;
        }

        .wb-chat-resize-btn.is-expanded .fa-compress {
            display: inline-block;
        }

        .wb-sidebar {
            width: 360px;
            max-width: 42%;
            background: var(--wb-panel);
            border-inline-end: 1px solid var(--wb-border);
            display: flex;
            flex-direction: column;
            min-width: 300px;
        }

        .wb-sidebar-header {
            height: 64px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(180deg, rgba(0, 168, 132, 0.08), rgba(0, 168, 132, 0.03));
            border-bottom: 1px solid var(--wb-border);
        }

        .wb-sidebar-tools {
            display: none;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            padding: 10px 14px;
            background: #fff;
            border-bottom: 1px solid var(--wb-border);
        }

        .wb-sidebar-tool {
            min-width: 0;
            height: 40px;
            padding: 0 12px;
            border: 1px solid var(--wb-border);
            border-radius: 8px;
            background: #fff;
            color: rgba(17, 27, 33, 0.76);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
        }

        .wb-sidebar-tool:hover {
            color: var(--wb-green-dark);
            border-color: rgba(0, 168, 132, 0.24);
            background: rgba(0, 168, 132, 0.06);
            text-decoration: none;
        }

        .wb-sidebar-tool.is-primary {
            color: #fff;
            background: var(--wb-green-dark);
            border-color: var(--wb-green-dark);
        }

        .wb-sidebar-tool.is-primary:hover {
            color: #fff;
            background: #006f5c;
            border-color: #006f5c;
        }

        .wb-sidebar-tool:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .wb-sidebar-close,
        .wb-sidebar-backdrop {
            display: none !important;
        }

        .wb-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: var(--wb-text);
            letter-spacing: 0.2px;
        }

        .wb-wa-badge {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: var(--wb-green);
            color: #fff;
            display: grid;
            place-items: center;
            box-shadow: 0 8px 18px rgba(0, 168, 132, 0.25);
            flex: 0 0 auto;
        }

        .wb-header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .wb-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            border: 1px solid var(--wb-border);
            background: #fff;
            color: rgba(0, 0, 0, 0.65);
            text-decoration: none;
        }

        .wb-icon-btn:hover {
            color: rgba(0, 0, 0, 0.85);
            border-color: rgba(0, 0, 0, 0.12);
        }

        .wb-icon-btn.is-recording {
            color: #d93025;
            border-color: rgba(217, 48, 37, 0.28);
            background: rgba(217, 48, 37, 0.08);
        }

        .wb-mobile-back {
            display: none;
        }

        .wb-search {
            padding: 10px 14px;
            border-bottom: 1px solid var(--wb-border);
            background: #fff;
        }

        .wb-filter-row {
            padding: 0 14px 10px;
            border-bottom: 1px solid var(--wb-border);
            background: #fff;
        }

        .wb-conversation-tabs {
            display: flex;
            flex: 0 0 auto;
            gap: 6px;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            padding: 10px 12px;
            overflow-x: auto;
            overflow-y: hidden;
            border-bottom: 1px solid var(--wb-border);
            background: #fff;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 128, 105, 0.35) transparent;
            overscroll-behavior-inline: contain;
        }

        .wb-conversation-tabs::-webkit-scrollbar {
            height: 5px;
        }

        .wb-conversation-tabs::-webkit-scrollbar-track {
            background: transparent;
        }

        .wb-conversation-tabs::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background: rgba(0, 128, 105, 0.3);
        }

        .wb-conversation-tab {
            flex: 0 0 auto;
            min-height: 34px;
            padding: 0 12px;
            border: 1px solid rgba(17, 27, 33, 0.1);
            border-radius: 17px;
            background: #fff;
            color: rgba(17, 27, 33, 0.68);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .wb-conversation-tab:hover {
            color: var(--wb-green-dark);
            border-color: rgba(0, 168, 132, 0.25);
            background: rgba(0, 168, 132, 0.05);
        }

        .wb-conversation-tab.is-active {
            color: #fff;
            border-color: var(--wb-green-dark);
            background: var(--wb-green-dark);
            box-shadow: 0 4px 12px rgba(0, 128, 105, 0.18);
        }

        .wb-conversation-tab i {
            font-size: 11px;
        }

        .wb-filter-select {
            width: 100%;
            height: 40px;
            border-radius: 12px;
            border: 1px solid var(--wb-border);
            padding: 0 12px;
            outline: none;
            background: rgba(0, 0, 0, 0.02);
            color: var(--wb-text);
        }

        .wb-filter-select:focus {
            border-color: rgba(0, 168, 132, 0.35);
            box-shadow: 0 0 0 3px rgba(0, 168, 132, 0.12);
            background: #fff;
        }

        .wb-search-box {
            position: relative;
        }

        .wb-search-box i {
            position: absolute;
            inset-inline-start: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(0, 0, 0, 0.45);
            font-size: 12px;
        }

        .wb-search-input {
            width: 100%;
            height: 40px;
            border-radius: 12px;
            border: 1px solid var(--wb-border);
            padding-inline-start: 36px;
            padding-inline-end: 12px;
            outline: none;
            background: rgba(0, 0, 0, 0.02);
        }

        .wb-search-input:focus {
            border-color: rgba(0, 168, 132, 0.35);
            box-shadow: 0 0 0 3px rgba(0, 168, 132, 0.12);
            background: #fff;
        }

        .wb-conv-list {
            overflow: auto;
            padding: 6px 6px 10px;
            margin-top: 10px;
        }

        .wb-conv-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 10px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--wb-text);
            border: 1px solid transparent;
        }

        .wb-conv-item:hover {
            background: rgba(0, 0, 0, 0.03);
        }

        .wb-conv-item.is-active {
            background: rgba(0, 168, 132, 0.08);
            border-color: rgba(0, 168, 132, 0.14);
        }

        .wb-conv-create-order-btn {
            flex: 0 0 auto;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            border: 1px solid rgba(0, 168, 132, 0.22);
            background: rgba(0, 168, 132, 0.08);
            color: var(--wb-green-dark);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            opacity: 0;
            transition: opacity 0.15s ease, background 0.15s ease, color 0.15s ease;
            cursor: pointer;
            margin-inline-start: 6px;
            align-self: center;
        }

        .wb-conv-item:hover .wb-conv-create-order-btn {
            opacity: 1;
        }

        .wb-conv-create-order-btn:hover {
            background: var(--wb-green);
            color: #fff;
            border-color: var(--wb-green);
        }

        .wb-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(0, 168, 132, 0.12);
            color: var(--wb-green-dark);
            display: grid;
            place-items: center;
            font-weight: 700;
            flex: 0 0 auto;
            overflow: hidden;
        }

        .wb-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .wb-conv-main {
            flex: 1 1 auto;
            min-width: 0;
        }

        .wb-conv-top {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 8px;
        }

        .wb-conv-name {
            font-weight: 700;
            font-size: 14px;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-conv-time {
            font-size: 11px;
            color: rgba(0, 0, 0, 0.45);
            flex: 0 0 auto;
        }

        .wb-conv-preview {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-top: 3px;
        }

        .wb-conv-snippet {
            font-size: 12px;
            color: var(--wb-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            min-width: 0;
        }

        .wb-conv-search-match {
            margin-top: 4px;
            color: var(--wb-muted);
            font-size: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-conv-search-match mark {
            padding: 0 2px;
            border-radius: 3px;
            background: #ffe58f;
            color: inherit;
        }

        .wb-conv-badge {
            max-width: 45%;
            height: 24px;
            padding: 0 8px;
            border-radius: 999px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: rgba(0, 0, 0, 0.03);
            color: rgba(0, 0, 0, 0.72);
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            flex: 0 0 auto;
        }

        .wb-conv-badge-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-conv-status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex: 0 0 auto;
            background: #dc3545;
        }

        .wb-conv-status-dot.is-open {
            background: #16a34a;
        }

        .wb-conv-status-dot.is-closed {
            background: #dc3545;
        }

        .wb-unread {
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            border-radius: 10px;
            background: var(--wb-green);
            color: #fff;
            font-size: 11px;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
        }

        .wb-chat {
            position: relative;
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            min-width: 0;
            background: var(--wb-panel);
        }

        .wb-chat-header {
            height: 64px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--wb-border);
            background: #fff;
        }

        .wb-chat-head-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .wb-contact-meta {
            min-width: 0;
        }

        .wb-contact-name {
            font-weight: 800;
            color: var(--wb-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 52vw;
        }

        .wb-contact-status {
            font-size: 12px;
            color: var(--wb-muted);
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-quick-actions {
            padding: 8px 14px;
            border-bottom: 1px solid var(--wb-border);
            background: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
            min-height: 48px;
        }

        .wb-qa-btn {
            width: 100%;
            min-height: 42px;
            padding: 0 14px;
            border-radius: 8px;
            border: 0;
            background: #fff;
            color: rgba(17, 27, 33, 0.86);
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-align: start;
        }

        .wb-qa-btn:hover {
            background: #f5f6f6;
            color: rgba(17, 27, 33, 0.96);
        }

        .wb-qa-btn:disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }

        .wb-action-menu {
            position: relative;
            flex: 0 0 auto;
        }

        .wb-action-menu-toggle {
            height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: #fff;
            color: rgba(17, 27, 33, 0.78);
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .wb-action-menu-toggle:hover,
        .wb-action-menu.is-open .wb-action-menu-toggle {
            border-color: rgba(0, 168, 132, 0.24);
            color: var(--wb-green-dark);
            background: rgba(0, 168, 132, 0.06);
        }

        .wb-action-menu-toggle .fa-angle-down {
            font-size: 11px;
            transition: transform 0.16s ease;
        }

        .wb-action-menu.is-open .wb-action-menu-toggle .fa-angle-down {
            transform: rotate(180deg);
        }

        .wb-action-menu-panel {
            position: absolute;
            inset-block-start: calc(100% + 8px);
            inset-inline-start: 0;
            z-index: 30;
            width: 220px;
            padding: 6px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: #fff;
            box-shadow: 0 18px 40px rgba(17, 27, 33, 0.16);
            display: none;
        }

        .wb-action-menu.is-open .wb-action-menu-panel {
            display: block;
        }

        .wb-action-menu-panel .wb-qa-btn i {
            width: 16px;
            color: rgba(0, 168, 132, 0.86);
        }

        .wb-action-menu-panel .wb-qa-btn+.wb-qa-btn {
            margin-top: 2px;
        }

        .wb-messages {
            flex: 1 1 auto;
            overflow: auto;
            padding: 14px 16px;
            background-color: var(--wb-chat-bg);
            background-image: radial-gradient(rgba(0, 0, 0, 0.04) 1px, transparent 1px);
            background-size: 22px 22px;
            background-position: 0 0;
        }

        .wb-empty {
            height: 100%;
            display: grid;
            place-items: center;
            color: rgba(0, 0, 0, 0.55);
            text-align: center;
            padding: 24px;
        }

        .wb-msg {
            display: flex;
            margin: 6px 0;
        }

        .wb-msg--out {
            justify-content: flex-end;
        }

        .wb-bubble {
            max-width: min(620px, 86%);
            padding: 8px 10px 6px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            position: relative;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .wb-msg--in .wb-bubble {
            background: var(--wb-in-msg);
            border-top-left-radius: 4px;
        }

        .wb-msg--out .wb-bubble {
            background: var(--wb-out-msg);
            border-top-right-radius: 4px;
        }

        .wb-text {
            color: rgba(0, 0, 0, 0.85);
            font-size: 18px;
            font-weight: 700;
            line-height: 1.6;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .wb-media-img,
        .wb-media-video {
            display: block;
            max-width: 320px;
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-top: 6px;
            background: #000;
        }

        .wb-audio-message-btn {
            margin-top: 6px;
            min-width: min(280px, 100%);
            min-height: 42px;
            border: 0;
            border-radius: 999px;
            padding: 8px 14px;
            background: rgba(255, 255, 255, 0.74);
            color: rgba(0, 0, 0, 0.78);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            text-align: start;
        }

        .wb-audio-message-btn:hover {
            background: rgba(255, 255, 255, 0.92);
        }

        .wb-audio-message-btn.is-active {
            color: var(--wb-green-dark);
            background: rgba(0, 168, 132, 0.12);
        }

        .wb-audio-message-btn i {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--wb-green);
            color: #fff;
            display: grid;
            place-items: center;
            font-size: 11px;
            flex: 0 0 auto;
        }

        .wb-audio-row {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
        }

        .wb-audio-dl-btn {
            flex: 0 0 auto;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.74);
            color: rgba(0, 0, 0, 0.6);
            display: grid;
            place-items: center;
            font-size: 13px;
            text-decoration: none;
        }

        .wb-audio-dl-btn:hover {
            background: rgba(255, 255, 255, 0.92);
            color: rgba(0, 0, 0, 0.85);
        }

        .wb-audio-message-btn {
            margin-top: 0;
        }

        .wb-audio-player {
            position: fixed;
            left: 50%;
            top: 76px;
            z-index: 1200;
            width: min(720px, calc(100vw - 32px));
            padding: 10px 12px;
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 18px 40px rgba(17, 27, 33, 0.16);
            display: none;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 10px;
            align-items: center;
            backdrop-filter: blur(10px);
            transform: translateX(-50%);
        }

        .wb-audio-player.is-visible {
            display: grid;
        }

        .wb-audio-player-main {
            min-width: 0;
        }

        .wb-audio-player-title {
            margin-bottom: 6px;
            color: var(--wb-text);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-audio-player audio {
            width: 100%;
            height: 38px;
            display: block;
        }

        .wb-audio-speed-btn {
            height: 28px;
            padding: 0 8px;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.12);
            background: #fff;
            color: rgba(0, 0, 0, 0.75);
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            line-height: 1;
        }

        .wb-audio-speed-btn:hover {
            border-color: rgba(0, 168, 132, 0.35);
            color: var(--wb-green-dark);
            background: rgba(0, 168, 132, 0.06);
        }

        .wb-audio-speed-btn.is-active {
            border-color: var(--wb-green-dark);
            background: var(--wb-green-dark);
            color: #fff;
        }

        .wb-audio-player-close {
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.06);
            color: rgba(0, 0, 0, 0.7);
            display: grid;
            place-items: center;
            flex: 0 0 auto;
        }

        @media (max-width: 768px) {
            .wb-audio-player {
                top: calc(env(safe-area-inset-top, 0px) + 12px);
                width: min(520px, calc(100vw - 20px));
                padding: 8px 10px;
                border-radius: 12px;
            }
        }

        .wb-doc {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 6px;
            padding: 10px 10px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: rgba(255, 255, 255, 0.65);
        }

        .wb-msg--out .wb-doc {
            background: rgba(255, 255, 255, 0.45);
        }

        .wb-doc-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: rgba(0, 0, 0, 0.06);
            color: rgba(0, 0, 0, 0.75);
            font-weight: 900;
            font-size: 12px;
            letter-spacing: 0.3px;
            flex: 0 0 auto;
            text-transform: uppercase;
        }

        .wb-doc-info {
            min-width: 0;
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .wb-doc-name {
            font-size: 13px;
            font-weight: 800;
            color: rgba(0, 0, 0, 0.86);
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-doc-name:hover {
            text-decoration: underline;
        }

        .wb-doc-meta {
            font-size: 11px;
            color: rgba(0, 0, 0, 0.52);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-doc-action {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: rgba(255, 255, 255, 0.75);
            color: rgba(0, 0, 0, 0.68);
            text-decoration: none;
            flex: 0 0 auto;
        }

        .wb-doc-action:hover {
            color: rgba(0, 0, 0, 0.9);
            border-color: rgba(0, 0, 0, 0.14);
            background: rgba(255, 255, 255, 0.92);
        }

        .wb-media-label {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 999px;
            background: rgba(0, 0, 0, 0.05);
            color: rgba(0, 0, 0, 0.68);
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .wb-meta {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
            align-items: center;
            margin-top: 4px;
            font-size: 11px;
            color: rgba(0, 0, 0, 0.45);
            user-select: none;
        }

        .wb-msg-sender {
            max-width: 180px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 600;
            color: rgba(0, 0, 0, 0.62);
        }

        .wb-status {
            font-size: 12px;
            letter-spacing: -0.5px;
            color: rgba(0, 0, 0, 0.5);
        }

        .wb-status.is-pending {
            color: #b26a00;
        }

        .wb-status.is-read {
            color: #53bdeb;
        }

        .wb-status.is-error {
            color: #d93025;
        }

        .wb-typing {
            padding: 8px 14px;
            background: rgba(255, 255, 255, 0.75);
            border-top: 1px solid var(--wb-border);
            color: rgba(0, 0, 0, 0.6);
            font-size: 12px;
        }

        .wb-composer {
            padding: 8px 10px;
            background: #f0f2f5;
            border-top: 1px solid var(--wb-border);
            position: relative;
        }

        .wb-composer-inner {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .wb-composer .wb-icon-btn {
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: #54656f;
            font-size: 17px;
        }

        .wb-composer .wb-icon-btn:hover,
        .wb-composer .wb-icon-btn.is-open {
            background: rgba(17, 27, 33, 0.08);
            color: #111b21;
        }

        .wb-composer-input {
            flex: 1 1 auto;
            min-width: 0;
            height: 44px;
            border-radius: 22px;
            border: 1px solid rgba(17, 27, 33, 0.08);
            background: #fff;
            padding: 0 16px;
            outline: none;
        }

        .wb-composer-input:focus {
            border-color: rgba(0, 168, 132, 0.35);
            box-shadow: 0 0 0 3px rgba(0, 168, 132, 0.12);
            background: #fff;
        }

        .wb-recording-indicator {
            display: none;
            flex: 1 1 auto;
            min-width: 0;
            height: 44px;
            border-radius: 22px;
            background: #fff;
            border: 1px solid rgba(239, 68, 68, 0.35);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.08);
            padding: 0 12px;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            animation: wb-recording-pulse-border 2s infinite ease-in-out;
        }

        .wb-recording-indicator.is-visible {
            display: flex;
        }

        .wb-recording-status {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            flex: 1 1 auto;
        }

        .wb-recording-dot {
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background-color: #ef4444;
            flex-shrink: 0;
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            animation: wb-recording-pulse-dot 1.2s infinite ease-in-out;
        }

        .wb-recording-timer {
            font-size: 15px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
            color: #ef4444;
            letter-spacing: 0.5px;
            flex-shrink: 0;
            min-width: 48px;
            direction: ltr;
            text-align: center;
        }

        .wb-recording-text {
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-recording-waves {
            display: flex;
            align-items: center;
            gap: 3px;
            height: 18px;
            flex-shrink: 0;
        }

        .wb-recording-waves span {
            display: inline-block;
            width: 3px;
            background-color: #ef4444;
            border-radius: 3px;
            animation: wb-recording-wave 1s ease-in-out infinite;
        }

        .wb-recording-waves span:nth-child(1) {
            height: 6px;
            animation-delay: 0.0s;
        }

        .wb-recording-waves span:nth-child(2) {
            height: 14px;
            animation-delay: 0.15s;
        }

        .wb-recording-waves span:nth-child(3) {
            height: 18px;
            animation-delay: 0.3s;
        }

        .wb-recording-waves span:nth-child(4) {
            height: 12px;
            animation-delay: 0.45s;
        }

        .wb-recording-waves span:nth-child(5) {
            height: 8px;
            animation-delay: 0.6s;
        }

        .wb-recording-cancel-btn {
            width: 34px !important;
            height: 34px !important;
            min-width: 34px;
            border-radius: 50% !important;
            border: 1px solid rgba(239, 68, 68, 0.2) !important;
            background: rgba(239, 68, 68, 0.08) !important;
            color: #ef4444 !important;
            font-size: 14px !important;
            cursor: pointer;
            display: grid;
            place-items: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .wb-recording-cancel-btn:hover {
            background: #ef4444 !important;
            color: #fff !important;
            transform: scale(1.08);
        }

        @keyframes wb-recording-pulse-dot {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }

            70% {
                transform: scale(1.15);
                box-shadow: 0 0 0 8px rgba(239, 68, 68, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        @keyframes wb-recording-pulse-border {

            0%,
            100% {
                border-color: rgba(239, 68, 68, 0.35);
            }

            50% {
                border-color: rgba(239, 68, 68, 0.75);
            }
        }

        @keyframes wb-recording-wave {

            0%,
            100% {
                transform: scaleY(0.4);
            }

            50% {
                transform: scaleY(1);
            }
        }

        .wb-composer .wb-icon-btn.is-recording {
            color: #fff !important;
            border-color: #ef4444 !important;
            background: #ef4444 !important;
            animation: wb-recording-pulse-dot 1.5s infinite;
        }

        .wb-composer-tools-menu {
            position: absolute;
            inset-inline-start: 10px;
            bottom: 62px;
            z-index: 55;
            width: 230px;
            padding: 6px;
            border: 1px solid rgba(17, 27, 33, 0.1);
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 18px 48px rgba(17, 27, 33, 0.2);
            display: none;
        }

        .wb-composer-tools-menu.is-open {
            display: block;
        }

        .wb-composer-tool {
            width: 100%;
            min-height: 46px;
            padding: 6px 10px;
            border: 0;
            border-radius: 8px;
            background: #fff;
            color: #111b21;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 700;
            text-align: start;
        }

        .wb-composer-tool:hover {
            background: #f5f6f6;
        }

        .wb-composer-tool:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .wb-composer-tool-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #fff;
            flex: 0 0 auto;
        }

        .wb-composer-tool-icon.is-document {
            background: #7f66ff;
        }

        .wb-composer-tool-icon.is-quick {
            background: #f59e0b;
        }

        .wb-composer-error {
            margin-top: 8px;
            padding: 8px 10px;
            border-radius: 12px;
            border: 1px solid rgba(220, 53, 69, 0.25);
            background: rgba(220, 53, 69, 0.08);
            color: rgba(176, 42, 55, 0.95);
            font-size: 13px;
            display: none;
        }

        .wb-reply-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border: 1px solid var(--wb-border);
            border-radius: 12px;
            background: rgba(0, 0, 0, 0.03);
            margin-bottom: 10px;
        }

        .wb-reply-side {
            width: 4px;
            height: 34px;
            border-radius: 999px;
            background: var(--wb-green);
            flex: 0 0 auto;
        }

        .wb-reply-content {
            min-width: 0;
            flex: 1 1 auto;
        }

        .wb-reply-title {
            font-size: 12px;
            font-weight: 800;
            color: var(--wb-green-dark);
            margin-bottom: 2px;
        }

        .wb-reply-snippet {
            font-size: 12px;
            color: rgba(0, 0, 0, 0.7);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-reply-close {
            border: 0;
            background: transparent;
            color: rgba(0, 0, 0, 0.55);
            padding: 6px;
            border-radius: 10px;
            cursor: pointer;
            flex: 0 0 auto;
        }

        .wb-reply-close:hover {
            background: rgba(0, 0, 0, 0.06);
        }

        .wb-reply-quote {
            border-inline-start: 4px solid var(--wb-green);
            padding-inline-start: 10px;
            margin-bottom: 8px;
            background: rgba(0, 0, 0, 0.03);
            border-radius: 10px;
            padding: 8px 10px;
            cursor: pointer;
        }

        .wb-reply-quote-title {
            font-size: 12px;
            font-weight: 800;
            color: var(--wb-green-dark);
            margin-bottom: 2px;
        }

        .wb-reply-quote-body {
            font-size: 12px;
            color: rgba(0, 0, 0, 0.75);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-msg-actions {
            display: inline-flex;
            gap: 6px;
            margin-inline-start: 10px;
        }

        .wb-msg-action {
            border: 0;
            background: transparent;
            color: rgba(0, 0, 0, 0.45);
            padding: 4px 6px;
            border-radius: 8px;
            cursor: pointer;
            line-height: 1;
        }

        .wb-msg-action:hover {
            background: rgba(0, 0, 0, 0.06);
            color: rgba(0, 0, 0, 0.7);
        }

        .wb-msg-action.is-danger:hover {
            background: rgba(198, 40, 40, 0.12);
            color: #c62828;
        }

        .wb-msg-action[disabled],
        .wb-msg-action:disabled {
            opacity: 0.35;
            cursor: not-allowed;
            pointer-events: none;
        }

        .wb-send-btn {
            flex: 0 0 auto;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 0;
            background: var(--wb-green);
            color: #fff;
            display: grid;
            place-items: center;
        }

        .wb-send-btn:hover {
            background: var(--wb-green-dark);
        }

        .wb-qr-panel {
            position: absolute;
            left: 12px;
            right: 12px;
            bottom: 68px;
            background: #fff;
            border: 1px solid var(--wb-border);
            border-radius: 14px;
            box-shadow: 0 18px 60px rgba(0, 0, 0, 0.16);
            overflow: hidden;
            z-index: 50;
        }

        .wb-qr-head {
            padding: 10px 12px;
            border-bottom: 1px solid var(--wb-border);
            display: flex;
            gap: 10px;
            align-items: center;
            background: linear-gradient(180deg, rgba(0, 168, 132, 0.08), rgba(0, 168, 132, 0.02));
        }

        .wb-qr-search {
            flex: 1 1 auto;
            height: 38px;
            border-radius: 12px;
            border: 1px solid var(--wb-border);
            background: rgba(0, 0, 0, 0.02);
            padding: 0 12px;
            outline: none;
        }

        .wb-qr-list {
            max-height: 320px;
            overflow: auto;
        }

        .wb-qr-item {
            padding: 10px 12px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            cursor: pointer;
        }

        .wb-qr-item:hover {
            background: rgba(0, 168, 132, 0.06);
        }

        .wb-qr-title {
            font-weight: 900;
            color: rgba(0, 0, 0, 0.82);
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .wb-qr-shortcut {
            display: inline-flex;
            align-items: center;
            height: 22px;
            padding: 0 8px;
            border-radius: 999px;
            border: 1px solid rgba(0, 168, 132, 0.18);
            background: rgba(0, 168, 132, 0.08);
            color: rgba(0, 128, 105, 0.95);
            font-size: 12px;
            font-weight: 900;
        }

        .wb-qr-body {
            margin-top: 4px;
            font-size: 12px;
            color: rgba(0, 0, 0, 0.6);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
            z-index: 2000;
        }

        .wb-modal.is-open {
            display: flex;
        }

        .wb-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.46);
            backdrop-filter: blur(2px);
        }

        .wb-modal-card {
            position: relative;
            width: min(520px, 95vw);
            max-height: 85vh;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--wb-border);
            box-shadow: 0 22px 70px rgba(0, 0, 0, 0.22);
            display: flex;
            flex-direction: column;
        }

        .wb-modal-header {
            height: 64px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--wb-border);
            background: linear-gradient(180deg, rgba(0, 168, 132, 0.08), rgba(0, 168, 132, 0.02));
        }

        .wb-modal-title {
            font-weight: 800;
            color: rgba(0, 0, 0, 0.82);
        }

        .wb-modal-body {
            padding: 12px 14px 14px;
            overflow: auto;
        }

        .wb-contact-list {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .wb-contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 10px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: #fff;
            cursor: pointer;
        }

        .wb-contact-item:hover {
            border-color: rgba(0, 168, 132, 0.24);
            background: rgba(0, 168, 132, 0.05);
        }

        .wb-contact-main {
            min-width: 0;
            flex: 1 1 auto;
        }

        .wb-modal .wb-contact-name {
            font-weight: 800;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-modal .wb-contact-phone {
            font-size: 12px;
            color: rgba(0, 0, 0, 0.55);
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-load-more {
            width: 100%;
            height: 42px;
            border-radius: 12px;
            margin-top: 10px;
            border: 1px solid var(--wb-border);
            background: #fff;
            color: rgba(0, 0, 0, 0.75);
            font-weight: 700;
        }

        .wb-load-more:hover {
            border-color: rgba(0, 0, 0, 0.14);
            color: rgba(0, 0, 0, 0.9);
        }

        .wb-pills {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .wb-pill {
            height: 30px;
            padding: 0 10px;
            border-radius: 999px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: #fff;
            color: rgba(0, 0, 0, 0.72);
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            user-select: none;
        }

        .wb-pill.is-open {
            border-color: rgba(0, 168, 132, 0.25);
            color: rgba(0, 128, 105, 0.95);
            background: rgba(0, 168, 132, 0.07);
        }

        .wb-pill.is-resolved {
            border-color: rgba(34, 34, 34, 0.2);
            color: rgba(0, 0, 0, 0.75);
            background: rgba(0, 0, 0, 0.04);
        }

        .wb-tag-pill {
            height: 26px;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: rgba(0, 0, 0, 0.03);
        }

        .wb-tag-remove {
            width: 18px;
            height: 18px;
            border-radius: 999px;
            border: 0;
            background: rgba(0, 0, 0, 0.06);
            color: inherit;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0;
        }

        .wb-tag-remove:hover {
            background: rgba(0, 0, 0, 0.12);
        }

        .wb-form-row {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .wb-input {
            height: 40px;
            border-radius: 12px;
            border: 1px solid var(--wb-border);
            padding: 0 12px;
            outline: none;
            background: rgba(0, 0, 0, 0.02);
            min-width: 220px;
        }

        .wb-color-picker {
            width: 56px;
            min-width: 56px;
            padding: 0;
        }

        .wb-input:focus {
            border-color: rgba(0, 168, 132, 0.35);
            box-shadow: 0 0 0 3px rgba(0, 168, 132, 0.12);
            background: #fff;
        }

        .wb-textarea {
            width: 100%;
            min-height: 110px;
            border-radius: 12px;
            border: 1px solid var(--wb-border);
            padding: 10px 12px;
            outline: none;
            background: rgba(0, 0, 0, 0.02);
            resize: vertical;
        }

        .wb-textarea:focus {
            border-color: rgba(0, 168, 132, 0.35);
            box-shadow: 0 0 0 3px rgba(0, 168, 132, 0.12);
            background: #fff;
        }

        .wb-primary {
            height: 40px;
            padding: 0 14px;
            border-radius: 12px;
            border: 1px solid rgba(0, 168, 132, 0.25);
            background: var(--wb-green);
            color: #fff;
            font-weight: 800;
        }

        .wb-primary:hover {
            background: var(--wb-green-dark);
        }

        .wb-secondary {
            height: 40px;
            padding: 0 14px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background: #fff;
            color: rgba(0, 0, 0, 0.75);
            font-weight: 800;
        }

        .wb-note-item {
            padding: 10px 10px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: #fff;
        }

        .wb-note-meta {
            font-size: 12px;
            color: rgba(0, 0, 0, 0.55);
            margin-bottom: 6px;
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .wb-msg.is-highlighted .wb-bubble {
            border-color: rgba(0, 168, 132, 0.55);
            box-shadow: 0 0 0 4px rgba(0, 168, 132, 0.16);
        }

        .wb-search-results {
            margin-top: 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-height: 160px;
        }

        .wb-search-result {
            padding: 12px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: #fff;
            cursor: pointer;
        }

        .wb-search-result:hover {
            border-color: rgba(0, 168, 132, 0.24);
            background: rgba(0, 168, 132, 0.04);
        }

        .wb-search-result-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            font-size: 12px;
            color: rgba(0, 0, 0, 0.55);
            margin-bottom: 6px;
        }

        .wb-search-result-body {
            color: rgba(0, 0, 0, 0.84);
            font-size: 14px;
            line-height: 1.5;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .wb-settings-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .wb-customer-snapshot {
            margin-bottom: 14px;
        }

        .wb-customer-snapshot-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
        }

        .wb-customer-snapshot-title {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--wb-text);
            font-size: 14px;
            font-weight: 800;
        }

        .wb-customer-snapshot-title i {
            color: var(--wb-green-dark);
        }

        .wb-customer-snapshot-label {
            color: var(--wb-muted);
            font-size: 11px;
        }

        .wb-customer-info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .wb-customer-info-item {
            min-width: 0;
            min-height: 76px;
            padding: 12px;
            border: 1px solid rgba(17, 27, 33, 0.08);
            border-radius: 8px;
            background: #fff;
            display: grid;
            grid-template-columns: 36px minmax(0, 1fr);
            align-items: center;
            gap: 10px;
        }

        .wb-customer-info-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(0, 168, 132, 0.1);
            color: var(--wb-green-dark);
            display: grid;
            place-items: center;
            font-size: 14px;
        }

        .wb-customer-info-content {
            min-width: 0;
        }

        .wb-customer-info-label {
            margin-bottom: 4px;
            color: var(--wb-muted);
            font-size: 11px;
            font-weight: 700;
        }

        .wb-customer-info-value {
            color: var(--wb-text);
            font-size: 13px;
            font-weight: 800;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .wb-customer-info-value.is-empty {
            color: rgba(17, 27, 33, 0.35);
            font-weight: 600;
        }

        .wb-settings-section-divider {
            height: 1px;
            margin-bottom: 14px;
            background: var(--wb-border);
        }

        .wb-settings-item {
            padding: 12px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: rgba(0, 0, 0, 0.015);
        }

        .wb-settings-label {
            font-size: 12px;
            color: rgba(0, 0, 0, 0.55);
            margin-bottom: 6px;
        }

        .wb-settings-value {
            color: rgba(0, 0, 0, 0.84);
            font-weight: 700;
            line-height: 1.45;
            word-break: break-word;
        }

        .wb-settings-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 14px;
        }

        .wb-settings-actions .wb-secondary,
        .wb-settings-actions .wb-primary {
            flex: 1 1 220px;
            justify-content: center;
            display: inline-flex;
            align-items: center;
        }

        .wb-account-tabs {
            margin-bottom: 14px;
            position: relative;
        }

        .wb-account-tabs-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 0 0 12px;
        }

        .wb-account-tabs-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            color: var(--wb-text);
        }

        .wb-account-tabs-sub {
            font-size: 12px;
            color: var(--wb-muted);
            white-space: nowrap;
        }

        .wb-account-mobile-toggle {
            display: none;
        }

        .wb-account-tabs-list {
            display: grid;
            grid-template-columns: repeat(var(--wb-accounts-columns, 1), minmax(0, 1fr));
            gap: 12px;
        }

        .wb-acc-item {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 16px;
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.05);
            background: linear-gradient(180deg, #ffffff, #fbfbfb);
            transition: transform 120ms ease, box-shadow 120ms ease, border-color 120ms ease, background 120ms ease;
            user-select: none;
            min-width: 0;
        }

        .wb-acc-item:hover {
            background: linear-gradient(180deg, #ffffff, #f7fbfa);
            transform: translateY(-1px);
        }

        .wb-acc-item.is-active {
            border-color: rgba(0, 168, 132, 0.22);
            background: linear-gradient(180deg, rgba(0, 168, 132, 0.08), rgba(0, 168, 132, 0.03));
            box-shadow: 0 8px 20px rgba(0, 168, 132, 0.10);
        }

        .wb-acc-avatar {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            font-weight: 900;
            color: var(--wb-green-dark);
            background: rgba(0, 168, 132, 0.10);
            letter-spacing: 0.5px;
            flex: 0 0 auto;
        }

        .wb-acc-body {
            min-width: 0;
            flex: 1 1 auto;
        }

        .wb-acc-name {
            font-weight: 800;
            color: var(--wb-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        .wb-acc-sub {
            margin-top: 4px;
            font-size: 12px;
            color: var(--wb-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wb-acc-state {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            font-size: 11px;
            font-weight: 700;
            color: rgba(0, 0, 0, 0.6);
            background: rgba(0, 0, 0, 0.03);
            padding: 4px 8px;
            border-radius: 999px;
            width: fit-content;
        }

        .wb-acc-status {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #adb5bd;
            flex: 0 0 auto;
        }

        .wb-acc-status.is-online {
            background: #22c55e;
        }

        .wb-current-account {
            padding: 10px 12px;
            border-bottom: 1px solid var(--wb-border);
            background: linear-gradient(180deg, rgba(0, 168, 132, 0.07), rgba(0, 168, 132, 0.02));
        }

        .wb-current-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 900;
            color: rgba(0, 0, 0, 0.72);
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .wb-current-row {
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .wb-current-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-weight: 900;
            background: rgba(0, 168, 132, 0.12);
            color: var(--wb-green-dark);
            flex: 0 0 auto;
        }

        .wb-current-meta {
            min-width: 0;
        }

        .wb-current-name {
            font-weight: 900;
            color: rgba(0, 0, 0, 0.86);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
        }

        .wb-current-sub {
            margin-top: 2px;
            font-size: 12px;
            color: rgba(0, 0, 0, 0.55);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
        }

        @media (max-width: 991px) {
            .wb-sidebar {
                width: 320px;
                min-width: 260px;
            }
        }

        @media (max-width: 768px) {
            #whats-chat-root {
                min-height: 0;
                --wb-mobile-viewport-height: 100dvh;
                --wb-mobile-inbox-top: 0px;
                --wb-mobile-bottom-clearance: env(safe-area-inset-bottom, 0px);
            }

            .wb-account-tabs {
                display: grid;
                grid-template-columns: auto auto;
                align-items: center;
                justify-content: space-between;
                gap: 8px;
                margin-bottom: 10px;
                z-index: 60;
                padding: 4px
            }

            .wb-inbox {
                position: relative;
                height: calc(var(--wb-mobile-viewport-height, 100dvh) - var(--wb-mobile-inbox-top, 0px) - var(--wb-mobile-bottom-clearance, env(safe-area-inset-bottom, 0px)) - 4px);
                min-height: 0;
                border-radius: 10px;
                isolation: isolate;
            }

            .wb-sidebar {
                position: absolute;
                inset-block: 0;
                inset-inline-start: 0;
                z-index: 50;
                width: min(400px, 88vw);
                max-width: 88vw;
                min-width: 300px;
                border-inline-end: 1px solid var(--wb-border);
                box-shadow: 14px 0 42px rgba(17, 27, 33, 0.2);
                transform: translate3d(-110%, 0, 0);
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: transform 0.24s ease, opacity 0.18s ease, visibility 0.24s ease;
                will-change: transform;
            }

            [dir="rtl"] .wb-sidebar {
                transform: translate3d(110%, 0, 0);
                box-shadow: -14px 0 42px rgba(17, 27, 33, 0.2);
            }

            #whats-chat-root.wb-mobile-mode--list .wb-sidebar {
                transform: translate3d(0, 0, 0);
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }

            .wb-chat {
                display: flex;
                width: 100%;
                min-width: 0;
            }

            .wb-sidebar-backdrop {
                position: absolute;
                inset: 0;
                z-index: 40;
                display: block;
                border: 0;
                padding: 0;
                background: rgba(17, 27, 33, 0.42);
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: opacity 0.2s ease, visibility 0.2s ease;
            }

            #whats-chat-root.wb-mobile-mode--list .wb-sidebar-backdrop {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }

            .wb-sidebar-close {
                display: grid !important;
            }

            .wb-sidebar-header>.wb-header-actions {
                display: none;
            }

            .wb-sidebar-tools {
                display: grid;
            }

            .wb-mobile-back {
                display: grid;
            }

            .wb-chat-header {
                flex: 0 0 64px;
            }

            .wb-quick-actions,
            .wb-composer {
                flex: 0 0 auto;
            }

            .wb-messages {
                min-height: 0;
                max-height: none;
            }

            .wb-account-tabs-list {
                position: absolute;
                inset-block-start: calc(100% + 6px);
                inset-inline-end: 0;
                z-index: 70;
                display: none;
                grid-template-columns: 1fr;
                gap: 6px;
                width: min(340px, 90vw);
                padding: 6px;
                border: 1px solid var(--wb-border);
                border-radius: 10px;
                background: #fff;
                box-shadow: 0 18px 40px rgba(17, 27, 33, 0.18);
            }

            .wb-account-tabs.is-open .wb-account-tabs-list {
                display: grid;
            }

            .wb-acc-item {
                min-width: 0;
            }
        }

        @media (max-width: 768px) {
            .wb-inbox {
                height: calc(var(--wb-mobile-viewport-height, 100dvh) - var(--wb-mobile-inbox-top, 0px) - var(--wb-mobile-bottom-clearance, env(safe-area-inset-bottom, 0px)) - 4px);
                min-height: 0;
                border: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .wb-account-tabs-head {
                align-items: center;
                flex-direction: row;
                padding: 0;
                min-width: 0;
            }

            .wb-account-tabs-title {
                gap: 6px;
                white-space: nowrap;
                font-size: 13px;
            }

            .wb-account-tabs-title .wb-wa-badge {
                width: 30px;
                height: 30px;
                border-radius: 8px;
            }

            .wb-account-tabs-sub {
                display: none;
            }

            .wb-account-mobile-toggle {
                width: fit-content;
                max-width: min(220px, 52vw);
                height: 38px;
                padding: 0 10px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                background: #fff;
                color: var(--wb-text);
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 8px;
                font-size: 12px;
                font-weight: 700;
                text-align: start;
            }

            .wb-account-mobile-toggle span {
                min-width: 0;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .wb-account-mobile-toggle .fa-angle-down {
                flex: 0 0 auto;
                transition: transform 0.16s ease;
            }

            .wb-account-tabs.is-open .wb-account-mobile-toggle {
                border-color: rgba(0, 168, 132, 0.35);
                box-shadow: 0 0 0 3px rgba(0, 168, 132, 0.1);
            }

            .wb-account-tabs.is-open .wb-account-mobile-toggle .fa-angle-down {
                transform: rotate(180deg);
            }

            .wb-account-tabs-list {
                grid-template-columns: 1fr;
            }

            .wb-acc-item {
                min-height: 72px;
                padding: 10px 12px;
                border-radius: 10px;
                justify-content: flex-start;
            }

            .wb-acc-avatar {
                display: grid;
                width: 42px;
                height: 42px;
                border-radius: 10px;
            }

            .wb-acc-body {
                flex: 1 1 auto;
                text-align: start;
            }

            .wb-acc-name {
                font-size: 13px;
                line-height: 1.25;
            }

            .wb-acc-sub {
                display: block;
                margin-top: 3px;
                font-size: 11px;
            }

            .wb-acc-state {
                display: inline-flex;
                margin-top: 5px;
                padding: 2px 7px;
                font-size: 10px;
            }

            .wb-sidebar {
                width: min(360px, 92vw);
                max-width: 92vw;
                min-width: 0;
            }

            .wb-sidebar-header,
            .wb-chat-header {
                height: 58px;
                padding: 8px 10px;
            }

            .wb-sidebar-tools {
                padding: 8px 10px;
            }

            .wb-conversation-tabs {
                padding: 8px 10px;
                scrollbar-width: none;
            }

            .wb-conversation-tabs::-webkit-scrollbar {
                display: none;
            }

            .wb-conversation-tab {
                min-height: 32px;
                padding: 0 10px;
                font-size: 11px;
            }

            .wb-chat-head-left {
                gap: 8px;
            }

            .wb-chat-header .wb-avatar {
                width: 38px;
                height: 38px;
            }

            .wb-contact-name {
                max-width: 38vw;
                font-size: 14px;
            }

            .wb-contact-status {
                max-width: 38vw;
                font-size: 11px;
            }

            .wb-chat-header>.wb-header-actions {
                gap: 4px;
            }

            .wb-chat-header>.wb-header-actions .wb-pill {
                display: none;
            }

            .wb-chat-header .wb-icon-btn {
                width: 36px;
                height: 36px;
                border: 0;
                background: transparent;
            }

            .wb-quick-actions {
                min-height: 44px;
                padding: 5px 10px;
            }

            .wb-action-menu-toggle {
                height: 32px;
            }

            .wb-pills {
                flex-wrap: nowrap;
                overflow-x: auto;
                scrollbar-width: none;
            }

            .wb-pills::-webkit-scrollbar {
                display: none;
            }

            .wb-pill {
                flex: 0 0 auto;
            }

            .wb-messages {
                padding: 10px;
            }

            .wb-bubble {
                max-width: 90%;
            }

            .wb-text {
                font-size: 17px;
            }

            .wb-composer-inner {
                gap: 4px;
                padding: 0;
            }

            .wb-composer .wb-icon-btn,
            .wb-send-btn {
                flex: 0 0 auto;
            }

            .wb-composer .wb-icon-btn {
                width: 36px;
                height: 36px;
            }

            .wb-send-btn {
                width: 40px;
                height: 40px;
            }

            .wb-composer-input {
                padding: 0 12px;
            }

            .wb-composer-tools-menu {
                inset-inline: 8px auto;
                bottom: 58px;
                width: min(230px, calc(100vw - 24px));
            }

            .wb-customer-info-grid {
                grid-template-columns: 1fr;
            }

            .wb-customer-info-item {
                min-height: 68px;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $accounts = $accounts ?? collect();
        $selectedAccount = $selectedAccountId ? $accounts->firstWhere('id', $selectedAccountId) : null;
        $activeContact = $activeContact ?? null;
        $allowedAccounts = $accounts;
        $allowedAccountsCount = $accounts->count();
        $accountTabsColumns = max(1, min($allowedAccountsCount, 3));
        $snoozeUiEnabled = false;
        $selectedAccountName = $selectedAccount
            ? ($selectedAccount->name ?: (__('whatsapp_account') . ' #' . $selectedAccount->id))
            : __('whatsapp_no_account');
        $selectedAccountAvatar = $selectedAccount
            ? mb_strtoupper(mb_substr($selectedAccountName, 0, 2))
            : '--';
        $selectedAccountSub = $selectedAccount
            ? ($selectedAccount->phone_number_id ?: __('whatsapp_no_phone_number_id'))
            : __('whatsapp_no_allowed_accounts');
        $activeConversationFilter = request()->query('filter');
        if (!in_array($activeConversationFilter, ['all', 'unread', 'open', 'closed'], true)) {
            $activeConversationFilter = ($statusFilter ?? null) === 'open'
                ? 'open'
                : ((($statusFilter ?? null) === 'resolved') ? 'closed' : 'all');
        }
    @endphp
    <div id="whats-chat-root"
        data-active-conversation-id="{{ isset($activeConversation) && $activeConversation ? $activeConversation->id : '' }}"
        data-initial-messages-has-more="{{ !empty($messagesHasMore) ? '1' : '0' }}"
        data-initial-messages-before-id="{{ $messagesNextBeforeId ?? '' }}"
        data-selected-account-id="{{ isset($selectedAccount) && $selectedAccount ? $selectedAccount->id : '' }}"
        data-current-status-filter="{{ $statusFilter ?? '' }}" data-current-tag-filter="{{ $tagFilterId ?? '' }}"
        data-locale="{{ str_replace('_', '-', app()->getLocale()) }}"
        data-chat-index-url="{{ route('crm.whatsapp_chat.index', [], false) }}"
        data-conversations-url="{{ route('crm.whatsapp_chat.conversations', [], false) }}"
        data-messages-url-template="{{ route('crm.whatsapp_chat.messages', ['conversationId' => '__ID__'], false) }}"
        data-message-search-url-template="{{ route('crm.whatsapp_chat.messages.search', ['conversationId' => '__ID__'], false) }}"
        data-contacts-url="{{ route('crm.whatsapp_contacts', [], false) }}" data-csrf-token="{{ csrf_token() }}"
        data-meta-url-template="{{ route('crm.whatsapp_chat.meta', ['conversationId' => '__ID__'], false) }}"
        data-tags-url="{{ route('crm.whatsapp_chat.tags.index', [], false) }}"
        data-tags-store-url="{{ route('crm.whatsapp_chat.tags.store', [], false) }}"
        data-set-tags-url-template="{{ route('crm.whatsapp_chat.tags.set', ['conversationId' => '__ID__'], false) }}"
        data-add-note-url-template="{{ route('crm.whatsapp_chat.notes.store', ['conversationId' => '__ID__'], false) }}"
        data-resolve-url-template="{{ route('crm.whatsapp_chat.resolve', ['conversationId' => '__ID__'], false) }}"
        data-send-message-url="{{ route('crm.whatsapp_chat.store', [], false) }}"
        data-quick-replies-url="{{ route('crm.whatsapp_chat.quickReplies', [], false) }}"
        data-media-url="{{ route('crm.whatsapp_chat.media', [], false) }}"
        data-message-media-url-template="{{ route('crm.whatsapp_chat.messageMedia', ['messageId' => '__ID__'], false) }}"
        data-delete-message-url-template="{{ route('crm.whatsapp_chat.messages.delete', ['messageId' => '__ID__'], false) }}"
        data-t-contacts-api-unavailable="{{ __('whatsapp_contacts_api_unavailable') }}"
        data-t-load-contacts-error="{{ __('whatsapp_load_contacts_error') }}"
        data-t-no-tags-available="{{ __('whatsapp_no_tags_available') }}"
        data-t-tags-api-unavailable="{{ __('whatsapp_tags_api_unavailable') }}"
        data-t-load-tags-error="{{ __('whatsapp_load_tags_error') }}" data-t-no-notes="{{ __('whatsapp_no_notes') }}"
        data-t-system="{{ __('whatsapp_system') }}" data-t-open="{{ __('whatsapp_open') }}"
        data-t-resolved="{{ __('whatsapp_resolved') }}"
        data-t-snoozed="{{ __('whatsapp_snoozed') }}"
        data-t-unassigned="{{ __('whatsapp_unassigned') }}" data-t-loading="{{ __('whatsapp_loading') }}"
        data-t-no-results="{{ __('whatsapp_no_results') }}"
        data-t-search-hint="{{ __('whatsapp_search_hint') }}"
        data-t-search-no-results="{{ __('whatsapp_search_no_results') }}"
        data-t-search-loading="{{ __('whatsapp_search_loading') }}"
        data-t-message-not-visible="{{ __('whatsapp_search_message_not_visible') }}"
        data-t-settings-notes-empty="{{ __('whatsapp_notes_empty') }}"
        data-can-update-tags="1">
        <div class="wb-account-tabs" style="--wb-accounts-columns: {{ $accountTabsColumns }};">
            <div class="wb-account-tabs-head">
                <div class="wb-account-tabs-title">
                    <span class="wb-wa-badge">
                        <i class="fab fa-whatsapp"></i>
                    </span>
                    <span>{{ __('whatsapp_accounts_title') }}</span>
                </div>
                <div class="wb-account-tabs-sub">{{ __('whatsapp_accounts_subtitle') }}</div>
            </div>
            <button class="wb-account-mobile-toggle" type="button" id="wb-account-mobile-toggle" aria-expanded="false"
                aria-controls="wb-account-tabs-list">
                <span>{{ $selectedAccountName }}</span>
                <i class="fa fa-angle-down"></i>
            </button>
            <div class="wb-account-tabs-list" id="wb-account-tabs-list">
                @forelse($allowedAccounts as $account)
                    @php
                        $accountName = $account->name ?: (__('whatsapp_account') . ' #' . $account->id);
                        $accountAvatar = mb_strtoupper(mb_substr($accountName, 0, 2));
                    @endphp
                    <a class="wb-acc-item {{ isset($selectedAccount) && $selectedAccount && $selectedAccount->id === $account->id ? 'is-active' : '' }}"
                        href="{{ route('crm.whatsapp_chat.index', array_filter(['account_id' => $account->id, 'filter' => request()->query('filter'), 'status' => $statusFilter ?? null], fn($value) => $value !== null && $value !== '')) }}"
                        title="{{ $accountName }}">
                        <span class="wb-acc-avatar">{{ $accountAvatar }}</span>
                        <span class="wb-acc-body">
                            <span class="wb-acc-name">{{ $accountName }}</span>
                            <span class="wb-acc-sub">{{ $account->phone_number_id ?: __('whatsapp_no_phone_number_id') }}</span>
                            <span class="wb-acc-state">
                                <span class="wb-acc-status {{ $account->is_active ? 'is-online' : '' }}"></span>
                                {{ $account->is_active ? __('active') : __('inactive') }}
                            </span>
                        </span>
                    </a>
                @empty
                    <div class="wb-empty" style="padding:10px 4px;font-size:12px;">{{ __('whatsapp_no_allowed_accounts') }}</div>
                @endforelse
            </div>
        </div>

        <div class="wb-inbox">
            <div class="wb-sidebar">
                <div class="wb-sidebar-header">
                    <div class="wb-title">
                        <span class="wb-wa-badge">
                            <i class="fab fa-whatsapp"></i>
                        </span>
                        <span>{{ __('whatsapp_inbox') }}</span>
                    </div>
                    <div class="wb-header-actions">
                        <a class="wb-icon-btn" href="{{ route('crm.whatsapp_contacts') }}"
                            title="{{ __('whatsapp_contacts') }}">
                            <i class="fa fa-address-book"></i>
                        </a>
                        <button class="wb-icon-btn" type="button" id="wb-new-chat-btn" title="{{ __('whatsapp_new_chat') }}"
                            {{ isset($selectedAccount) && $selectedAccount ? '' : 'disabled' }}>
                            <i class="fa fa-edit"></i>
                        </button>
                    </div>
                    <button class="wb-icon-btn wb-sidebar-close" type="button" id="wb-sidebar-close"
                        title="{{ __('close') }}">
                        <i class="fa fa-times"></i>
                    </button>
                </div>

                <div class="wb-sidebar-tools">
                    <a class="wb-sidebar-tool" href="{{ route('crm.whatsapp_contacts') }}">
                        <i class="fa fa-address-book"></i>
                        <span>{{ __('whatsapp_contacts') }}</span>
                    </a>
                    <button class="wb-sidebar-tool is-primary" type="button" data-wb-new-chat-trigger {{ isset($selectedAccount) && $selectedAccount ? '' : 'disabled' }}>
                        <i class="fa fa-edit"></i>
                        <span>{{ __('whatsapp_new_chat') }}</span>
                    </button>
                </div>

                <div class="wb-search">
                    <div class="wb-search-box">
                        <i class="fa fa-search"></i>
                        <input type="text" class="wb-search-input" id="wb-chat-search" placeholder="{{ __('whatsapp_search_conversations') }}">
                    </div>
                </div>

                <div class="wb-conversation-tabs" id="wb-conversation-tabs" role="tablist"
                    aria-label="{{ __('whatsapp_filter_conversations') }}">
                    <button class="wb-conversation-tab {{ $activeConversationFilter === 'all' ? 'is-active' : '' }}"
                        type="button" role="tab"
                        aria-selected="{{ $activeConversationFilter === 'all' ? 'true' : 'false' }}"
                        data-conversation-filter="all">
                        <i class="fa fa-comments-o"></i>
                        <span>{{ __('whatsapp_all') }}</span>
                    </button>
                    <button class="wb-conversation-tab {{ $activeConversationFilter === 'unread' ? 'is-active' : '' }}"
                        type="button" role="tab"
                        aria-selected="{{ $activeConversationFilter === 'unread' ? 'true' : 'false' }}"
                        data-conversation-filter="unread">
                        <i class="fa fa-envelope-o"></i>
                        <span>{{ __('whatsapp_filter_unread') }}</span>
                    </button>
                    <button class="wb-conversation-tab {{ $activeConversationFilter === 'open' ? 'is-active' : '' }}"
                        type="button" role="tab"
                        aria-selected="{{ $activeConversationFilter === 'open' ? 'true' : 'false' }}"
                        data-conversation-filter="open">
                        <i class="fa fa-circle-o"></i>
                        <span>{{ __('whatsapp_filter_open') }}</span>
                    </button>
                    <button class="wb-conversation-tab {{ $activeConversationFilter === 'closed' ? 'is-active' : '' }}"
                        type="button" role="tab"
                        aria-selected="{{ $activeConversationFilter === 'closed' ? 'true' : 'false' }}"
                        data-conversation-filter="closed">
                        <i class="fa fa-check-circle-o"></i>
                        <span>{{ __('whatsapp_filter_closed') }}</span>
                    </button>
                </div>

                <div class="wb-conv-list">
                    @php
                        $selectedId = isset($activeConversation) && $activeConversation ? $activeConversation->id : null;
                    @endphp
                    @if(isset($conversations) && $conversations->count() > 0)
                        @foreach($conversations as $conv)
                            @php
                                $name = $conv->display_name ?: $conv->wa_id;
                                $initial = mb_substr($name, 0, 1);
                                $lastMessage = $conv->lastMessage;
                                $lastBody = $lastMessage ? (string) $lastMessage->body : '';
                                $lastType = $lastMessage && $lastMessage->type ? strtolower(trim((string) $lastMessage->type)) : 'text';
                                $preview = $lastType !== 'text'
                                    ? match ($lastType) {
                                        'image'    => __('whatsapp_image'),
                                        'video'    => __('whatsapp_video'),
                                        'audio'    => __('whatsapp_voice'),
                                        'document' => ($lastBody ?: __('whatsapp_file')),
                                        'sticker'  => __('whatsapp_sticker'),
                                        default    => ($lastBody ?: __('whatsapp_message')),
                                    }
                                    : ($lastBody ?: '');
                            @endphp
                            <a href="{{ route('crm.whatsapp_chat.index', array_filter(['account_id' => $selectedAccount ? $selectedAccount->id : null, 'conversation_id' => $conv->id, 'filter' => request()->query('filter'), 'status' => $statusFilter ?? null], fn($value) => $value !== null && $value !== '')) }}"
                                class="wb-conv-item {{ $selectedId === $conv->id ? 'is-active' : '' }}"
                                data-conversation-id="{{ $conv->id }}" data-wa-id="{{ $conv->wa_id }}"
                                data-display-name="{{ $conv->display_name }}" data-profile-pic="{{ $conv->profile_pic }}">
                                @if(!empty($conv->profile_pic))
                                    <div class="wb-avatar">
                                        <img src="{{ $conv->profile_pic }}" alt="avatar">
                                    </div>
                                @else
                                    <div class="wb-avatar">{{ $initial }}</div>
                                @endif
                                <div class="wb-conv-main">
                                    <div class="wb-conv-top">
                                        <div class="wb-conv-name">{{ $name }}</div>
                                        <div class="wb-conv-time">
                                            {{ $conv->last_message_at ? $conv->last_message_at->locale(app()->getLocale())->isoFormat('DD MMM YYYY, hh:mm A') : '' }}
                                        </div>
                                    </div>
                                    <div class="wb-conv-preview">
                                        <div class="wb-conv-snippet">{{ $preview }}</div>
                                        @if(($conv->unread_count ?? 0) > 0)
                                            <div class="wb-unread">{{ $conv->unread_count }}</div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="wb-empty">{{ __('whatsapp_no_conversations_yet') }}</div>
                    @endif
                </div>
            </div>

            <button class="wb-sidebar-backdrop" type="button" id="wb-sidebar-backdrop"
                aria-label="{{ __('close') }}"></button>

            <div class="wb-chat">
                <div class="wb-chat-header">
                    <div class="wb-chat-head-left">
                        <button class="wb-icon-btn wb-mobile-back" type="button" id="wb-mobile-back"
                            title="{{ __('whatsapp_back_to_conversations') }}">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        @php
                            $activeName = null;
                            if (isset($activeConversation) && $activeConversation) {
                                $activeName = $activeConversation->display_name ?: ($activeContact && $activeContact->name ? $activeContact->name : $activeConversation->wa_id);
                            }
                            $activeInitial = $activeName ? mb_substr($activeName, 0, 1) : '';
                        @endphp

                        @if(isset($activeContact) && $activeContact && $activeContact->profile_pic)
                            <div class="wb-avatar">
                                <img src="{{ $activeContact->profile_pic }}" alt="avatar">
                            </div>
                        @else
                            <div class="wb-avatar">{{ $activeInitial }}</div>
                        @endif

                        <div class="wb-contact-meta">
                            <div class="wb-contact-name">
                                @if(isset($activeConversation) && $activeConversation)
                                    {{ $activeName }}
                                @else
                                    {{ __('whatsapp_select_conversation') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="wb-header-actions">
                        @if(isset($selectedAccount) && $selectedAccount)
                            <span class="wb-pill">
                                <i class="fa fa-id-badge"></i>
                                {{ $selectedAccountName }}
                            </span>
                        @endif
                        <button class="wb-icon-btn" type="button" id="wb-message-search-btn" title="{{ __('search') }}" {{ isset($activeConversation) && $activeConversation ? '' : 'disabled' }}>
                            <i class="fa fa-search"></i>
                        </button>
                        <button class="wb-icon-btn wb-chat-resize-btn" type="button" id="wb-chat-resize-btn"
                            title="{{ __('whatsapp_expand_chat') }}"
                            aria-label="{{ __('whatsapp_expand_chat') }}"
                            aria-pressed="false">
                            <i class="fa fa-expand"></i>
                            <i class="fa fa-compress"></i>
                        </button>
                        <button class="wb-icon-btn" type="button" id="wb-chat-settings-btn"
                            title="{{ __('whatsapp_more') }}" {{ isset($activeConversation) && $activeConversation ? '' : 'disabled' }}>
                            <i class="fa fa-ellipsis-v"></i>
                        </button>
                    </div>
                </div>

                <div class="wb-quick-actions">
                    <div class="wb-action-menu" id="wb-action-menu">
                        <button class="wb-action-menu-toggle" type="button" id="wb-action-menu-toggle" aria-expanded="false"
                            aria-controls="wb-action-menu-panel">
                            <i class="fa fa-ellipsis-v"></i>
                            <span>{{ __('whatsapp_conversation_options') }}</span>
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <div class="wb-action-menu-panel" id="wb-action-menu-panel">
                            <button class="wb-qa-btn" type="button" id="wb-tag-btn"><i class="fa fa-tag"></i>
                                {{ __('whatsapp_tag') }}</button>
                            <button class="wb-qa-btn" type="button" id="wb-note-btn"><i class="fa fa-sticky-note"></i>
                                {{ __('whatsapp_note') }}</button>
                            <button class="wb-qa-btn" type="button" id="wb-resolve-btn"><i class="fa fa-check-circle"></i>
                                {{ __('whatsapp_resolve') }}</button>
                            @if($snoozeUiEnabled)
                                <button class="wb-qa-btn" type="button" disabled><i class="fa fa-clock-o"></i>
                                    {{ __('whatsapp_snooze') }}</button>
                            @endif
                        </div>
                    </div>
                    @php
                        $initConvStatus = (isset($activeConversation) && $activeConversation) ? ($activeConversation->status ?? 'open') : null;
                        $initStatusResolved = $initConvStatus === 'resolved';
                        $initStatusSnoozed = $initConvStatus === 'snoozed';
                    @endphp
                    <div class="wb-pills" style="margin-inline-start:auto;">
                        @if($initConvStatus !== null)
                            <span class="wb-pill {{ $initStatusResolved ? 'is-resolved' : 'is-open' }}" id="wb-status-pill"
                                style="display:inline-flex;">
                                <i
                                    class="fa {{ $initStatusResolved ? 'fa-check-circle' : ($initStatusSnoozed ? 'fa-clock-o' : 'fa-circle') }}"></i>
                                {{ $initStatusResolved ? __('whatsapp_resolved') : ($initStatusSnoozed ? __('whatsapp_snoozed') : __('whatsapp_open')) }}
                            </span>
                        @else
                            <span class="wb-pill" id="wb-status-pill" style="display:none;"></span>
                        @endif
                        <span id="wb-tags-pills" style="display:none;"></span>
                    </div>
                </div>

                <div class="wb-messages">
                    @if(isset($activeConversation) && $activeConversation)
                        @if(isset($messages) && $messages->count() > 0)
                            @foreach($messages as $msg)
                                @php
                                    $isOut = $msg->direction === 'out';
                                    $time = $msg->wa_timestamp
                                        ? $msg->wa_timestamp->locale(app()->getLocale())->isoFormat('DD MMM YYYY, hh:mm A')
                                        : ($msg->created_at ? $msg->created_at->locale(app()->getLocale())->isoFormat('DD MMM YYYY, hh:mm A') : '');
                                    $messageType = (string) $msg->type;
                                    $mediaLabel = match ($messageType) {
                                        'image' => __('whatsapp_image'),
                                        'video' => __('whatsapp_video'),
                                        'audio' => null,
                                        'document' => null,
                                        'sticker' => __('whatsapp_sticker'),
                                        default => null,
                                    };
                                    $rawFilename = trim((string) (data_get($msg->raw, 'document.filename') ?: data_get($msg->raw, 'uploaded_media_name') ?: ''));
                                    $docFilename = $rawFilename !== '' ? $rawFilename : trim((string) ($msg->body ?? ''));
                                    if ($docFilename === '') {
                                        $docFilename = __('whatsapp_file');
                                    }
                                    $docExt = strtoupper((string) pathinfo($docFilename, PATHINFO_EXTENSION));
                                    if ($docExt === '') {
                                        $docExt = 'FILE';
                                    }
                                    $docExt = mb_substr($docExt, 0, 8);
                                    $docMime = (string) (data_get($msg->raw, 'document.mime_type') ?: data_get($msg->raw, 'uploaded_media_mime') ?: '');
                                    $docCaptionCandidate = trim((string) ($msg->body ?? ''));
                                    $docCaption = ($messageType === 'document' && $rawFilename !== '' && $docCaptionCandidate !== '' && $docCaptionCandidate !== $rawFilename)
                                        ? $docCaptionCandidate
                                        : null;
                                    $messageBody = $messageType === 'document' ? $docCaption : $msg->body;
                                    if (
                                        $mediaLabel
                                        && $messageType !== 'document'
                                        && preg_match('/^[^\\\\\\/]+\\.[A-Za-z0-9]{2,8}$/', trim((string) $messageBody))
                                    ) {
                                        $messageBody = null;
                                    }
                                    $voicePlaceholder = app()->getLocale() === 'ar' ? 'رسالة صوتية' : 'Voice message';
                                    $voicePlayerTitle = trim($voicePlaceholder . ($activeName ? ' - ' . $activeName : ''));
                                    $mediaContentUrl = $messageType !== 'text'
                                        ? route('crm.whatsapp_chat.messageMedia', ['messageId' => $msg->id], false)
                                        : null;
                                    $docDownloadUrl = ($messageType === 'document' && $mediaContentUrl) ? ($mediaContentUrl . '?download=1') : null;
                                @endphp
                                <div class="wb-msg {{ $isOut ? 'wb-msg--out' : 'wb-msg--in' }}" data-message-id="{{ $msg->id }}">
                                    <div class="wb-bubble">
                                        @if($mediaLabel)
                                            <div class="wb-media-label">{{ $mediaLabel }}</div>
                                        @endif
                                        @if($messageType === 'image' && $mediaContentUrl)
                                            <img class="wb-media-img" src="{{ $mediaContentUrl }}" loading="lazy" alt="Image">
                                        @endif
                                        @if($messageType === 'video' && $mediaContentUrl)
                                            <video class="wb-media-video" controls preload="metadata" playsinline>
                                                <source src="{{ $mediaContentUrl }}">
                                            </video>
                                        @endif
                                        @if($messageType === 'audio' && $mediaContentUrl)
                                            <div class="wb-audio-row">
                                                <button class="wb-audio-message-btn" type="button" data-action="play-audio"
                                                    data-message-id="{{ $msg->id }}" data-audio-src="{{ $mediaContentUrl }}"
                                                    data-audio-title="{{ $voicePlayerTitle }}">
                                                    <i class="fa fa-play"></i>
                                                    <span>{{ $voicePlaceholder }}</span>
                                                </button>
                                                <a class="wb-audio-dl-btn" href="{{ $mediaContentUrl }}?download=1" download
                                                    title="{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            </div>
                                        @endif
                                        @if($messageType === 'document')
                                            <div class="wb-doc">
                                                <div class="wb-doc-icon">{{ $docExt }}</div>
                                                <div class="wb-doc-info">
                                                    @if($docDownloadUrl)
                                                        <a class="wb-doc-name" href="{{ $docDownloadUrl }}" target="_blank"
                                                            rel="noopener">{{ $docFilename }}</a>
                                                    @else
                                                        <div class="wb-doc-name">{{ $docFilename }}</div>
                                                    @endif
                                                    <div class="wb-doc-meta">{{ $docMime !== '' ? $docMime : $docExt }}</div>
                                                </div>
                                                @if($docDownloadUrl)
                                                    <a class="wb-doc-action" href="{{ $docDownloadUrl }}" target="_blank" rel="noopener"
                                                        title="{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                        @if($messageType === 'text' || ($messageBody !== null && trim((string) $messageBody) !== '') || $messageType === 'audio')
                                                <div class="wb-text">
                                                    {{ $messageType === 'text'
                                            ? $msg->body
                                            : ($messageType === 'audio' && ($messageBody === null || trim((string) $messageBody) === '') ? $voicePlaceholder : $messageBody) }}
                                                </div>
                                        @endif
                                        <div class="wb-meta">
                                            <span>{{ $time }}</span>
                                            @if($isOut)
                                                @php
                                                    $statusValue = strtolower(trim((string) ($msg->message_status ?? '')));
                                                    $statusIcon = $statusValue === 'read' || $statusValue === 'delivered' ? '✓✓' : '✓';
                                                    $statusClass = $statusValue === 'read' ? 'wb-status is-read' : 'wb-status';
                                                @endphp
                                                <span class="{{ $statusClass }}">{{ $statusIcon }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="wb-empty">{{ __('whatsapp_no_messages') }}</div>
                        @endif
                    @else
                        <div class="wb-empty">
                            <div>
                                <div style="font-weight: 800; color: rgba(0,0,0,0.75); margin-bottom: 6px;">
                                    {{ __('whatsapp_inbox') }}</div>
                                <div>{{ __('whatsapp_choose_conversation') }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="wb-typing" id="wb-typing-indicator" style="display:none;">
                    {{ __('whatsapp_typing_now') }}
                </div>

                <div class="wb-composer">
                    <form class="wb-composer-form" method="post" action="{{ route('crm.whatsapp_chat.store') }}">
                        @csrf
                        <input type="hidden" name="account_id"
                            value="{{ isset($selectedAccount) && $selectedAccount ? $selectedAccount->id : '' }}">
                        <input type="hidden" name="to"
                            value="{{ isset($activeConversation) && $activeConversation ? $activeConversation->wa_id : '' }}">
                        <input type="hidden" name="reply_to_wamid" value="">
                        <div class="wb-reply-bar" id="wb-reply-bar" style="display:none;">
                            <div class="wb-reply-side"></div>
                            <div class="wb-reply-content">
                                <div class="wb-reply-title" id="wb-reply-title"></div>
                                <div class="wb-reply-snippet" id="wb-reply-snippet"></div>
                            </div>
                            <button class="wb-reply-close" type="button" id="wb-reply-close" title="{{ __('close') }}">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="wb-composer-inner">
                            <button class="wb-icon-btn" type="button" id="wb-composer-tools-btn"
                                title="{{ __('whatsapp_add_attachment') }}" aria-expanded="false"
                                aria-controls="wb-composer-tools-menu" {{ isset($activeConversation) && $activeConversation ? '' : 'disabled' }}>
                                <i class="fa fa-plus"></i>
                            </button>
                            <input type="text" name="message" class="wb-composer-input" id="wb-composer-input"
                                placeholder="{{ __('whatsapp_type_message') }}" autocomplete="off" {{ isset($activeConversation) && $activeConversation ? '' : 'disabled' }}>
                            <div class="wb-recording-indicator" id="wb-recording-indicator" style="display:none;">
                                <button class="wb-icon-btn wb-recording-cancel-btn" type="button"
                                    id="wb-recording-cancel-btn"
                                    title="{{ __('whatsapp_cancel_recording') }}">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                                <div class="wb-recording-status">
                                    <span class="wb-recording-dot"></span>
                                    <span class="wb-recording-timer" id="wb-recording-timer">00:00</span>
                                    <span class="wb-recording-waves">
                                        <span></span><span></span><span></span><span></span><span></span>
                                    </span>
                                    <span
                                        class="wb-recording-text">{{ app()->getLocale() === 'ar' ? 'جاري التسجيل...' : 'Recording...' }}</span>
                                </div>
                            </div>
                            <button class="wb-icon-btn" type="button" id="wb-audio-btn" title="{{ __('whatsapp_voice') }}"
                                {{ isset($activeConversation) && $activeConversation ? '' : 'disabled' }}>
                                <i class="fa fa-microphone"></i>
                            </button>
                            <button class="wb-send-btn" type="submit" {{ isset($activeConversation) && $activeConversation ? '' : 'disabled' }}>
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </div>
                        <div class="wb-composer-error" id="wb-composer-error"></div>
                    </form>
                    <input type="file" id="wb-file-input" style="display:none;">
                    <div class="wb-composer-tools-menu" id="wb-composer-tools-menu" aria-hidden="true">
                        <button class="wb-composer-tool" type="button" id="wb-attach-btn" {{ isset($activeConversation) && $activeConversation ? '' : 'disabled' }}>
                            <span class="wb-composer-tool-icon is-document"><i class="fa fa-paperclip"></i></span>
                            <span>{{ app()->getLocale() === 'ar' ? 'الصور والملفات' : 'Photos & Files' }}</span>
                        </button>
                        <button class="wb-composer-tool" type="button" id="wb-qr-btn" {{ isset($activeConversation) && $activeConversation ? '' : 'disabled' }}>
                            <span class="wb-composer-tool-icon is-quick"><i class="fa fa-bolt"></i></span>
                            <span>{{ __('whatsapp_quick_replies') }}</span>
                        </button>
                    </div>
                    <div class="wb-qr-panel" id="wb-qr-panel" style="display:none;">
                        <div class="wb-qr-head">
                            <input type="text" class="wb-qr-search" id="wb-qr-search"
                                placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث في الردود السريعة...' : 'Search quick replies...' }}">
                            <button class="wb-icon-btn" type="button" id="wb-qr-close" title="{{ __('close') }}">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="wb-qr-list" id="wb-qr-list"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wb-audio-player" id="wb-audio-player" aria-live="polite">
            <div class="wb-audio-player-main">
                <div class="wb-audio-player-title" id="wb-audio-player-title">
                    {{ app()->getLocale() === 'ar' ? 'رسالة صوتية' : 'Voice message' }}</div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <audio id="wb-global-audio" controls preload="metadata" style="flex:1;"></audio>
                    <div class="wb-audio-speed" style="display:flex; gap:4px; flex-shrink:0;">
                        <button type="button" class="wb-audio-speed-btn" data-speed="1" title="{{ app()->getLocale() === 'ar' ? 'سرعة عادية' : 'Normal speed' }}">x1</button>
                        <button type="button" class="wb-audio-speed-btn" data-speed="1.5" title="{{ app()->getLocale() === 'ar' ? 'سرعة 1.5x' : 'Speed 1.5x' }}">x1.5</button>
                        <button type="button" class="wb-audio-speed-btn" data-speed="2" title="{{ app()->getLocale() === 'ar' ? 'سرعة مضاعفة' : 'Speed 2x' }}">x2</button>
                    </div>
                </div>
            </div>
            <button class="wb-audio-player-close" type="button" id="wb-audio-player-close" title="{{ __('close') }}">
                <i class="fa fa-times"></i>
            </button>
        </div>

        <div class="wb-modal" id="wb-new-chat-modal" aria-hidden="true">
            <div class="wb-modal-backdrop" id="wb-new-chat-backdrop"></div>
            <div class="wb-modal-card" role="dialog" aria-modal="true">
                <div class="wb-modal-header">
                    <div class="wb-modal-title">{{ __('whatsapp_choose_contact') }}</div>
                    <button class="wb-icon-btn" type="button" id="wb-new-chat-close" title="{{ __('close') }}">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="wb-modal-body">
                    <div class="wb-search-box">
                        <i class="fa fa-search"></i>
                        <input type="text" class="wb-search-input" id="wb-contact-search"
                            placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث بالاسم أو الرقم...' : 'Search by name or number...' }}">
                    </div>

                    <div class="wb-contact-list" id="wb-contact-list">
                        <div class="wb-empty">{{ app()->getLocale() === 'ar' ? 'اكتب للبحث أو افتح القائمة' : 'Type to search or open the list' }}</div>
                    </div>

                    <button class="wb-load-more" type="button" id="wb-contact-more" style="display:none;">{{ app()->getLocale() === 'ar' ? 'تحميل المزيد' : 'Load more' }}</button>
                </div>
            </div>
        </div>


        <div class="wb-modal" id="wb-tags-modal" aria-hidden="true">
            <div class="wb-modal-backdrop" id="wb-tags-backdrop"></div>
            <div class="wb-modal-card" role="dialog" aria-modal="true">
                <div class="wb-modal-header">
                    <div class="wb-modal-title">{{ __('whatsapp_chat_tags') }}</div>
                    <button class="wb-icon-btn" type="button" id="wb-tags-close" title="{{ __('close') }}">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="wb-modal-body">
                    <div class="wb-search-box">
                        <i class="fa fa-search"></i>
                        <input type="text" class="wb-search-input" id="wb-tags-search" placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث في الوسوم...' : 'Search tags...' }}">
                    </div>

                    <div class="wb-contact-list" id="wb-tags-list">
                        <div class="wb-empty">{{ __('whatsapp_loading') }}</div>
                    </div>

                    <div class="wb-form-row" style="margin-top: 12px;">
                        <input type="text" class="wb-input" id="wb-new-tag-name"
                            placeholder="{{ __('whatsapp_new_tag_placeholder') }}">
                        <input type="color" class="wb-input wb-color-picker" id="wb-new-tag-color-picker" value="#6c757d">
                        <input type="text" class="wb-input" id="wb-new-tag-color" placeholder="{{ app()->getLocale() === 'ar' ? 'لون (مثال: #ffcc00)' : 'Color (e.g. #ffcc00)' }}">
                        <button class="wb-secondary" type="button" id="wb-create-tag-btn">{{ app()->getLocale() === 'ar' ? 'إضافة' : 'Add' }}</button>
                    </div>

                    <div class="wb-form-row" style="margin-top: 12px;">
                        <button class="wb-primary" type="button"
                            id="wb-save-tags-btn">{{ app()->getLocale() === 'ar' ? 'حفظ الوسوم' : 'Save tags' }}</button>
                        <button class="wb-secondary" type="button"
                            id="wb-clear-tags-btn">{{ app()->getLocale() === 'ar' ? 'إزالة كل الوسوم' : 'Remove all tags' }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="wb-modal" id="wb-notes-modal" aria-hidden="true">
            <div class="wb-modal-backdrop" id="wb-notes-backdrop"></div>
            <div class="wb-modal-card" role="dialog" aria-modal="true">
                <div class="wb-modal-header">
                    <div class="wb-modal-title">{{ __('whatsapp_internal_note') }}</div>
                    <button class="wb-icon-btn" type="button" id="wb-notes-close" title="{{ __('close') }}">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="wb-modal-body">
                    <textarea class="wb-textarea" id="wb-note-body"
                        placeholder="{{ app()->getLocale() === 'ar' ? 'اكتب ملاحظة داخلية (العميل لا يراها)...' : 'Write an internal note (the customer cannot see it)...' }}"></textarea>
                    <div class="wb-form-row" style="margin-top: 10px;">
                        <button class="wb-primary" type="button" id="wb-add-note-btn">{{ app()->getLocale() === 'ar' ? 'حفظ الملاحظة' : 'Save note' }}</button>
                    </div>
                    <div style="margin-top: 12px; font-weight: 800; color: rgba(0,0,0,0.7);">{{ app()->getLocale() === 'ar' ? 'آخر الملاحظات' : 'Recent notes' }}</div>
                    <div class="wb-contact-list" id="wb-notes-list" style="margin-top: 10px;">
                        <div class="wb-empty">{{ app()->getLocale() === 'ar' ? 'لا توجد ملاحظات' : 'No notes yet' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wb-modal" id="wb-message-search-modal" aria-hidden="true">
            <div class="wb-modal-backdrop" id="wb-message-search-backdrop"></div>
            <div class="wb-modal-card" role="dialog" aria-modal="true">
                <div class="wb-modal-header">
                    <div class="wb-modal-title">
                        {{ app()->getLocale() === 'ar' ? 'البحث داخل المحادثة' : 'Search Conversation' }}</div>
                    <button class="wb-icon-btn" type="button" id="wb-message-search-close" title="{{ __('close') }}">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="wb-modal-body">
                    <div class="wb-search-box">
                        <i class="fa fa-search"></i>
                        <input type="text" class="wb-search-input" id="wb-message-search-input"
                            placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث داخل الرسائل...' : 'Search messages...' }}">
                    </div>
                    <div class="wb-search-results" id="wb-message-search-results">
                        <div class="wb-empty">
                            {{ app()->getLocale() === 'ar' ? 'اكتب كلمة للبحث داخل هذه المحادثة' : 'Type to search inside this conversation' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wb-modal" id="wb-chat-settings-modal" aria-hidden="true">
            <div class="wb-modal-backdrop" id="wb-chat-settings-backdrop"></div>
            <div class="wb-modal-card" role="dialog" aria-modal="true">
                <div class="wb-modal-header">
                    <div class="wb-modal-title">{{ app()->getLocale() === 'ar' ? 'إعدادات الشات' : 'Chat Settings' }}</div>
                    <button class="wb-icon-btn" type="button" id="wb-chat-settings-close" title="{{ __('close') }}">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="wb-modal-body">
                    <div class="wb-settings-grid" id="wb-chat-settings-summary">
                        <div class="wb-empty">{{ __('whatsapp_loading') }}</div>
                    </div>
                    <div class="wb-settings-actions">
                        <button class="wb-secondary" type="button"
                            id="wb-settings-tags-btn">{{ __('whatsapp_tag') }}</button>
                        <button class="wb-secondary" type="button"
                            id="wb-settings-notes-btn">{{ __('whatsapp_note') }}</button>
                        <button class="wb-primary" type="button"
                            id="wb-settings-resolve-btn">{{ __('whatsapp_resolve') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lamejs/1.2.1/lame.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script>
        (function () {
            let isLoading = false;
            const root = document.getElementById('whats-chat-root');
            if (!root) return;
            let activeConversationId = root && root.dataset.activeConversationId ? Number(root.dataset.activeConversationId) : null;
            const selectedAccountId = root && root.dataset.selectedAccountId ? Number(root.dataset.selectedAccountId) : null;
            let currentStatusFilter = root && root.dataset.currentStatusFilter ? String(root.dataset.currentStatusFilter) : '';
            let currentTagFilter = '';
            let currentConversationFilter = (function () {
                let requested = '';
                try {
                    requested = new URLSearchParams(window.location.search || '').get('filter') || '';
                } catch (e) {
                    requested = '';
                }
                if (['all', 'unread', 'open', 'closed', 'assigned'].indexOf(requested) !== -1) {
                    return requested;
                }
                if (currentStatusFilter === 'open') return 'open';
                if (currentStatusFilter === 'resolved') return 'closed';
                return 'all';
            })();
            const currentLocale = root && root.dataset.locale ? root.dataset.locale : (document.documentElement.lang || 'en');
            const chatIndexUrl = root ? root.dataset.chatIndexUrl : '';
            const convUrl = root ? root.dataset.conversationsUrl : '';
            const msgUrlTemplate = root ? root.dataset.messagesUrlTemplate : '';
            const messageSearchUrlTemplate = root ? root.dataset.messageSearchUrlTemplate : '';
            const contactsUrl = root ? root.dataset.contactsUrl : '';
            const csrfToken = root ? root.dataset.csrfToken : '';
            const metaUrlTemplate = root ? root.dataset.metaUrlTemplate : '';
            const tagsUrl = root ? root.dataset.tagsUrl : '';
            const tagsStoreUrl = root ? root.dataset.tagsStoreUrl : '';
            const setTagsUrlTemplate = root ? root.dataset.setTagsUrlTemplate : '';
            const addNoteUrlTemplate = root ? root.dataset.addNoteUrlTemplate : '';
            const resolveUrlTemplate = root ? root.dataset.resolveUrlTemplate : '';
            const sendMessageUrl = root ? root.dataset.sendMessageUrl : '';
            const quickRepliesUrl = root ? root.dataset.quickRepliesUrl : '';
            const mediaUrl = root ? root.dataset.mediaUrl : '';
            const messageMediaUrlTemplate = root ? root.dataset.messageMediaUrlTemplate : '';
            const deleteMessageUrlTemplate = root ? root.dataset.deleteMessageUrlTemplate : '';
            const canUpdateTags = true;
            const t = {
                contactsApiUnavailable: root ? root.dataset.tContactsApiUnavailable : '',
                loadContactsError: root ? root.dataset.tLoadContactsError : '',
                noAgents: root ? root.dataset.tNoAgents : '',
                adminsApiUnavailable: root ? root.dataset.tAdminsApiUnavailable : '',
                loadAgentsError: root ? root.dataset.tLoadAgentsError : '',
                noTagsAvailable: root ? root.dataset.tNoTagsAvailable : '',
                tagsApiUnavailable: root ? root.dataset.tTagsApiUnavailable : '',
                loadTagsError: root ? root.dataset.tLoadTagsError : '',
                noNotes: root ? root.dataset.tNoNotes : '',
                system: root ? root.dataset.tSystem : '',
                open: root ? root.dataset.tOpen : '',
                resolved: root ? root.dataset.tResolved : '',
                snoozed: root ? root.dataset.tSnoozed : '',
                unassigned: root ? root.dataset.tUnassigned : '',
                loading: root ? root.dataset.tLoading : '',
                noResults: root ? root.dataset.tNoResults : '',
                searchHint: root ? root.dataset.tSearchHint : '',
                searchNoResults: root ? root.dataset.tSearchNoResults : '',
                searchLoading: root ? root.dataset.tSearchLoading : '',
                messageNotVisible: root ? root.dataset.tMessageNotVisible : '',
                settingsNotesEmpty: root ? root.dataset.tSettingsNotesEmpty : ''
            };
            // Scroll to bottom of server-rendered messages immediately before first AJAX tick
            (function () {
                var box = document.querySelector('.wb-messages');
                if (box) box.scrollTop = box.scrollHeight;
            })();

            let conversationsCache = [];
            let conversationSearchTerm = '';
            let conversationsNextOffset = 0;
            let conversationsHasMore = true;
            let conversationsLoadingMore = false;
            let messagesCache = [];
            let messagesSignature = '';
            let messagesHasMore = root.dataset.initialMessagesHasMore === '1';
            let messagesNextBeforeId = root.dataset.initialMessagesBeforeId ? Number(root.dataset.initialMessagesBeforeId) : null;
            let messagesLoadingOlder = false;
            let isFirstMessagesRender = true;
            let currentReplyToWamid = '';
            let contactsNextUrl = null;
            let contactsLoading = false;
            let metaCache = null;
            let metaLoadingConversationId = null;
            let quickRepliesCache = [];
            let quickRepliesLoaded = false;
            let messageSearchTimer = null;

            function setConversationControlsEnabled(enabled) {
                [
                    'wb-message-search-btn',
                    'wb-chat-settings-btn',
                    'wb-composer-tools-btn',
                    'wb-attach-btn',
                    'wb-qr-btn',
                    'wb-audio-btn'
                ].forEach(function (id) {
                    const element = document.getElementById(id);
                    if (!element) return;
                    if (enabled) {
                        element.removeAttribute('disabled');
                    } else {
                        element.setAttribute('disabled', 'disabled');
                    }
                });

                const input = document.getElementById('wb-composer-input');
                const sendButton = document.querySelector('form.wb-composer-form button[type="submit"]');
                if (input) enabled ? input.removeAttribute('disabled') : input.setAttribute('disabled', 'disabled');
                if (sendButton) enabled ? sendButton.removeAttribute('disabled') : sendButton.setAttribute('disabled', 'disabled');
            }

            function updateActiveConversationUi(conversation) {
                const name = conversation && (conversation.display_name || conversation.wa_id)
                    ? (conversation.display_name || conversation.wa_id)
                    : '';
                const header = document.querySelector('.wb-chat-header .wb-chat-head-left');
                const currentAvatar = header ? header.querySelector('.wb-avatar') : null;
                if (currentAvatar) {
                    currentAvatar.outerHTML = avatarHtml(conversation ? conversation.profile_pic : '', name);
                }

                const nameEl = document.querySelector('.wb-chat-header .wb-contact-name');
                const statusEl = document.querySelector('.wb-chat-header .wb-contact-status');
                if (nameEl) nameEl.textContent = name;
                if (statusEl) statusEl.textContent = formatContactStatus(conversation && conversation.last_activity);

                const form = document.querySelector('form.wb-composer-form');
                const toInput = form ? form.querySelector('input[name="to"]') : null;
                const accountInput = form ? form.querySelector('input[name="account_id"]') : null;
                if (toInput) toInput.value = conversation && conversation.wa_id ? conversation.wa_id : '';
                if (accountInput && selectedAccountId !== null) accountInput.value = String(selectedAccountId);

                setConversationControlsEnabled(!!conversation);
            }

            function markActiveConversationOnline() {
                const statusEl = document.querySelector('.wb-chat-header .wb-contact-status');
                if (statusEl) statusEl.textContent = currentLocale.indexOf('ar') === 0 ? 'متصل الآن' : 'Online now';
            }

            function formatContactStatus(value) {
                if (!value) return '';
                const timestamp = new Date(value).getTime();
                if (!isNaN(timestamp) && Math.abs(Date.now() - timestamp) <= 60000) {
                    return currentLocale.indexOf('ar') === 0 ? 'متصل الآن' : 'Online now';
                }
                const seconds = Math.max(1, Math.floor(Math.abs(Date.now() - timestamp) / 1000));
                const units = currentLocale.indexOf('ar') === 0
                    ? (seconds < 3600 ? [Math.floor(seconds / 60), 'دقيقة'] : seconds < 86400 ? [Math.floor(seconds / 3600), 'ساعة'] : [Math.floor(seconds / 86400), 'يوم'])
                    : (seconds < 3600 ? [Math.floor(seconds / 60), 'minute'] : seconds < 86400 ? [Math.floor(seconds / 3600), 'hour'] : [Math.floor(seconds / 86400), 'day']);
                const count = Math.max(1, units[0]);
                let label = units[1];
                if (currentLocale.indexOf('ar') !== 0 && count !== 1) label += 's';
                if (currentLocale.indexOf('ar') === 0 && count === 2) label = units[1] === 'دقيقة' ? 'دقيقتين' : units[1] === 'ساعة' ? 'ساعتين' : 'يومين';
                if (currentLocale.indexOf('ar') === 0 && count > 2 && count < 11) label = units[1] === 'دقيقة' ? 'دقائق' : units[1] === 'ساعة' ? 'ساعات' : 'أيام';
                return (currentLocale.indexOf('ar') === 0 ? 'نشط منذ ' : 'Active ') + count + ' ' + label;
            }

            function selectConversation(conversationId, conversation, pushHistory) {
                const nextId = Number(conversationId);
                if (!nextId || nextId === activeConversationId) return;

                if (typeof window.__cancelAudioRecording === 'function') {
                    window.__cancelAudioRecording();
                }

                activeConversationId = nextId;
                root.dataset.activeConversationId = String(nextId);
                metaCache = null;
                messagesCache = [];
                messagesSignature = '';
                messagesHasMore = true;
                messagesNextBeforeId = null;
                messagesLoadingOlder = false;
                isFirstMessagesRender = true;
                clearReplyToMessage();
                updateActiveConversationUi(conversation || {});

                const messagesBox = document.querySelector('.wb-messages');
                if (messagesBox) {
                    messagesBox.innerHTML = '<div class="wb-empty">' + escapeHtml(t.loading) + '</div>';
                }
                const statusPill = document.getElementById('wb-status-pill');
                const tagsPills = document.getElementById('wb-tags-pills');
                [statusPill, tagsPills].forEach(function (element) {
                    if (!element) return;
                    element.style.display = 'none';
                    element.innerHTML = '';
                });

                renderConversations(conversationsCache, $('#wb-chat-search').val());
                if (pushHistory && chatIndexUrl && window.history && typeof window.history.pushState === 'function') {
                    window.history.pushState(null, '', buildChatIndexUrl({ conversation_id: nextId, wa_id: null }));
                }
                if (isMobileView()) setMobileMode('chat');

                $.when(loadMessages(), loadMeta(), loadConversations()).always(function () {
                    // Each loader verifies the selected ID before rendering, so a late response
                    // from the previously opened conversation cannot replace this chat.
                });
            }

            function isMobileView() {
                if (window.matchMedia) {
                    return window.matchMedia('(max-width: 768px)').matches;
                }
                return window.innerWidth <= 768;
            }

            // Focus the composer after an explicit user action (send/reply/attach).
            // On mobile the keyboard should stay open between messages, just like WhatsApp.
            // Page-load auto-focus is prevented separately by blurComposerOnMobile().
            function focusComposerIfDesktop(input) {
                const el = input || document.getElementById('wb-composer-input');
                if (el) el.focus();
            }

            // Make sure the composer isn't focused when the page (re)appears on mobile —
            // covers both a fresh load and a back/forward-cache (bfcache) restore, where
            // the browser would otherwise restore focus and re-open the keyboard.
            function blurComposerOnMobile() {
                if (!isMobileView()) return;
                var composerEl = document.getElementById('wb-composer-input');
                if (composerEl && !composerEl.disabled) {
                    composerEl.setAttribute('tabindex', '-1');
                    document.addEventListener('touchstart', function mobileGuard() {
                        if (composerEl) composerEl.removeAttribute('tabindex');
                        document.removeEventListener('touchstart', mobileGuard);
                    }, { once: true, passive: true });
                }
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        if (document.activeElement && !document.activeElement.closest('.wb-sidebar')) {
                            document.activeElement.blur();
                        }
                    });
                });
            }

            function setMobileMode(mode) {
                root.classList.remove('wb-mobile-mode--list', 'wb-mobile-mode--chat');
                if (mode === 'chat') {
                    root.classList.add('wb-mobile-mode--chat');
                } else {
                    root.classList.add('wb-mobile-mode--list');
                }
            }

            function getUrlConversationId() {
                try {
                    const params = new URLSearchParams(window.location.search || '');
                    const id = params.get('conversation_id');
                    return id !== null && String(id).trim() !== '' ? String(id).trim() : null;
                } catch (e) {
                    return null;
                }
            }

            function buildChatIndexUrl(params) {
                const search = new URLSearchParams();
                if (selectedAccountId !== null && !isNaN(selectedAccountId)) {
                    search.set('account_id', String(selectedAccountId));
                }
                if (currentStatusFilter) {
                    search.set('status', String(currentStatusFilter));
                }
                if (currentTagFilter) {
                    search.set('tag_id', String(currentTagFilter));
                }
                if (currentConversationFilter && currentConversationFilter !== 'all') {
                    search.set('filter', currentConversationFilter);
                }
                Object.keys(params || {}).forEach(function (key) {
                    const value = params[key];
                    if (value === null || value === undefined || value === '') {
                        search.delete(key);
                        return;
                    }
                    search.set(key, String(value));
                });

                const query = search.toString();
                return chatIndexUrl + (query ? '?' + query : '');
            }

            (function initMobileLayout() {
                const tabletQuery = window.matchMedia
                    ? window.matchMedia('(max-width: 768px)')
                    : null;

                function isCompactView() {
                    return tabletQuery ? tabletQuery.matches : window.innerWidth <= 768;
                }

                const backBtn = document.getElementById('wb-mobile-back');
                const closeBtn = document.getElementById('wb-sidebar-close');
                const backdrop = document.getElementById('wb-sidebar-backdrop');
                const accountTabs = document.querySelector('.wb-account-tabs');
                const accountToggle = document.getElementById('wb-account-mobile-toggle');
                const inbox = root.querySelector('.wb-inbox');
                const bottomNavigation = document.querySelector('.mobile-bottom-nav');
                let viewportUpdateFrame = null;

                function updateMobileInboxHeight() {
                    if (!isCompactView() || !inbox) {
                        root.style.removeProperty('--wb-mobile-viewport-height');
                        root.style.removeProperty('--wb-mobile-inbox-top');
                        root.style.removeProperty('--wb-mobile-bottom-clearance');
                        return;
                    }

                    const visualViewport = window.visualViewport || null;
                    const viewportHeight = visualViewport ? visualViewport.height : window.innerHeight;
                    const viewportOffsetTop = visualViewport ? visualViewport.offsetTop : 0;
                    const inboxTop = Math.max(0, inbox.getBoundingClientRect().top - viewportOffsetTop);
                    let bottomClearance = 0;

                    if (bottomNavigation && window.getComputedStyle(bottomNavigation).display !== 'none') {
                        const navTop = bottomNavigation.getBoundingClientRect().top - viewportOffsetTop;
                        bottomClearance = Math.max(0, viewportHeight - navTop + 4);
                    }

                    root.style.setProperty('--wb-mobile-viewport-height', Math.round(viewportHeight) + 'px');
                    root.style.setProperty('--wb-mobile-inbox-top', Math.round(inboxTop) + 'px');
                    if (bottomClearance > 0) {
                        root.style.setProperty('--wb-mobile-bottom-clearance', Math.round(bottomClearance) + 'px');
                    } else {
                        root.style.removeProperty('--wb-mobile-bottom-clearance');
                    }
                }

                function scheduleMobileInboxHeight() {
                    if (viewportUpdateFrame) {
                        window.cancelAnimationFrame(viewportUpdateFrame);
                    }
                    viewportUpdateFrame = window.requestAnimationFrame(function () {
                        viewportUpdateFrame = null;
                        updateMobileInboxHeight();
                        // After the inbox resizes (keyboard open/close), re-pin the
                        // messages to the bottom so the latest message stays visible
                        // above the keyboard — matches WhatsApp scroll behaviour.
                        var msgBox = document.querySelector('.wb-messages');
                        if (msgBox) {
                            requestAnimationFrame(function () {
                                msgBox.scrollTop = msgBox.scrollHeight;
                            });
                        }
                    });
                }

                function syncResponsiveMode() {
                    if (isCompactView()) {
                        const explicitConversationId = getUrlConversationId();
                        setMobileMode(explicitConversationId || activeConversationId ? 'chat' : 'list');
                        scheduleMobileInboxHeight();
                        return;
                    }

                    root.classList.remove('wb-mobile-mode--list', 'wb-mobile-mode--chat');
                    setAccountMenuOpen(false);
                    updateMobileInboxHeight();
                }

                function openConversationDrawer() {
                    if (!isCompactView()) return;
                    setMobileMode('list');
                }

                function closeConversationDrawer() {
                    if (!isCompactView()) return;
                    setMobileMode('chat');
                }

                function setAccountMenuOpen(open) {
                    if (!accountTabs || !accountToggle) return;
                    accountTabs.classList.toggle('is-open', open);
                    accountToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                }

                if (accountToggle) {
                    accountToggle.addEventListener('click', function (event) {
                        event.preventDefault();
                        event.stopPropagation();
                        setAccountMenuOpen(!accountTabs.classList.contains('is-open'));
                    });
                }

                if (backBtn) {
                    backBtn.addEventListener('click', openConversationDrawer);
                }

                if (closeBtn) closeBtn.addEventListener('click', closeConversationDrawer);
                if (backdrop) backdrop.addEventListener('click', closeConversationDrawer);

                if (tabletQuery) {
                    if (typeof tabletQuery.addEventListener === 'function') {
                        tabletQuery.addEventListener('change', syncResponsiveMode);
                    } else if (typeof tabletQuery.addListener === 'function') {
                        tabletQuery.addListener(syncResponsiveMode);
                    }
                }

                window.addEventListener('resize', scheduleMobileInboxHeight);
                window.addEventListener('orientationchange', scheduleMobileInboxHeight);
                if (window.visualViewport) {
                    window.visualViewport.addEventListener('resize', scheduleMobileInboxHeight);
                    window.visualViewport.addEventListener('scroll', scheduleMobileInboxHeight);
                }
                if (bottomNavigation && typeof ResizeObserver !== 'undefined') {
                    const bottomNavigationObserver = new ResizeObserver(scheduleMobileInboxHeight);
                    bottomNavigationObserver.observe(bottomNavigation);
                }

                document.addEventListener('click', function (event) {
                    if (!accountTabs || !accountTabs.classList.contains('is-open')) return;
                    const inside = event.target && event.target.closest
                        ? event.target.closest('.wb-account-tabs')
                        : null;
                    if (!inside) setAccountMenuOpen(false);
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        setAccountMenuOpen(false);
                        if (root.classList.contains('wb-mobile-mode--list')) {
                            closeConversationDrawer();
                        }
                    }
                });

                syncResponsiveMode();
                window.setTimeout(scheduleMobileInboxHeight, 100);
            })();

            if (csrfToken) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
            }

            function escapeHtml(value) {
                if (value === null || value === undefined) return '';
                return String(value)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function formatLocalizedDateTime(value) {
                if (!value) return '';
                const d = new Date(value);
                if (isNaN(d.getTime())) return '';

                try {
                    return new Intl.DateTimeFormat(currentLocale, {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    }).format(d);
                } catch (error) {
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    const day = String(d.getDate()).padStart(2, '0');
                    const month = months[d.getMonth()] || '';
                    const year = d.getFullYear();
                    let hours = d.getHours();
                    const minutes = String(d.getMinutes()).padStart(2, '0');
                    const meridiem = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12 || 12;
                    return day + ' ' + month + ' ' + year + ', ' + String(hours).padStart(2, '0') + ':' + minutes + ' ' + meridiem;
                }
            }

            function formatTime(value) {
                return formatLocalizedDateTime(value);
            }

            function getOutgoingStatusMeta(status) {
                const value = status ? String(status).trim().toLowerCase() : '';
                if (value === 'uploading') {
                    return { text: currentLocale.indexOf('ar') === 0 ? 'جاري الرفع...' : 'Uploading...', className: 'wb-status is-pending' };
                }
                if (value === 'sending') {
                    return { text: currentLocale.indexOf('ar') === 0 ? 'جاري الإرسال...' : 'Sending...', className: 'wb-status is-pending' };
                }
                if (value === 'failed') {
                    return { text: currentLocale.indexOf('ar') === 0 ? 'فشل الإرسال' : 'Failed', className: 'wb-status is-error' };
                }
                if (value === 'deleted') {
                    return { text: currentLocale.indexOf('ar') === 0 ? 'تم الحذف' : 'Deleted', className: 'wb-status' };
                }
                if (value === 'read') {
                    return { text: '✓✓', className: 'wb-status is-read' };
                }
                if (value === 'delivered') {
                    return { text: '✓✓', className: 'wb-status' };
                }
                return { text: '✓', className: 'wb-status' };
            }

            function mediaPreviewLabel(type) {
                const v = type ? String(type).trim().toLowerCase() : 'text';
                if (v === 'image') return currentLocale.indexOf('ar') === 0 ? 'صورة' : 'Image';
                if (v === 'video') return currentLocale.indexOf('ar') === 0 ? 'فيديو' : 'Video';
                if (v === 'audio') return currentLocale.indexOf('ar') === 0 ? 'رسالة صوتية' : 'Voice message';
                if (v === 'document') return currentLocale.indexOf('ar') === 0 ? 'ملف' : 'File';
                if (v === 'sticker') return currentLocale.indexOf('ar') === 0 ? 'ملصق' : 'Sticker';
                return currentLocale.indexOf('ar') === 0 ? 'رسالة' : 'Message';
            }

            function currentConversationDisplayName() {
                const nameEl = document.querySelector('.wb-chat-header .wb-contact-name');
                return nameEl ? String(nameEl.textContent || '').trim() : '';
            }

            function audioPlayerTitleForCurrentConversation() {
                const label = currentLocale.indexOf('ar') === 0 ? 'رسالة صوتية' : 'Voice message';
                const name = currentConversationDisplayName();
                return name ? (label + ' - ' + name) : label;
            }

            function pickPreview(conv) {
                const last = conv && conv.last_message ? conv.last_message : null;
                const type = last && last.type ? String(last.type) : 'text';
                const normalized = type ? String(type).trim().toLowerCase() : 'text';
                const body = last && last.body ? String(last.body) : '';
                if (normalized && normalized !== 'text') {
                    if (normalized === 'document') {
                        return body || mediaPreviewLabel(normalized);
                    }
                    return mediaPreviewLabel(normalized);
                }
                return body;
            }

            function initials(name) {
                if (!name) return '';
                const s = String(name).trim();
                if (!s) return '';
                return s.slice(0, 1);
            }

            function avatarHtml(profilePic, name) {
                const pic = profilePic ? String(profilePic).trim() : '';
                if (pic) {
                    return '<div class="wb-avatar"><img src="' + escapeHtml(pic) + '" alt="avatar"></div>';
                }
                return '<div class="wb-avatar">' + escapeHtml(initials(name)) + '</div>';
            }

            function getConversationStatusDotClass(status) {
                return String(status || 'open') === 'open' ? 'is-open' : 'is-closed';
            }

            function highlightSearchMatch(value) {
                const text = value === null || value === undefined ? '' : String(value);
                const query = String(conversationSearchTerm || '').trim();
                if (!text || !query) return escapeHtml(text);

                const lowerText = text.toLocaleLowerCase();
                const lowerQuery = query.toLocaleLowerCase();
                let offset = 0;
                let html = '';
                let matchAt = lowerText.indexOf(lowerQuery, offset);
                while (matchAt !== -1) {
                    html += escapeHtml(text.slice(offset, matchAt));
                    html += '<mark>' + escapeHtml(text.slice(matchAt, matchAt + query.length)) + '</mark>';
                    offset = matchAt + query.length;
                    matchAt = lowerText.indexOf(lowerQuery, offset);
                }
                return html + escapeHtml(text.slice(offset));
            }

            function renderConversations(items, query) {
                const selectedId = activeConversationId;
                let html = '';
                const q = query ? String(query).trim().toLowerCase() : '';
                const filtered = (items || []).filter(function (conv) {
                    if (currentConversationFilter === 'unread' && Number(conv.unread_count || 0) <= 0) {
                        return false;
                    }
                    // The server searches all messages in a conversation, not just its preview.
                    // Do not filter its results again on the client.
                    if (conversationSearchTerm) return true;
                    if (!q) return true;
                    const name = (conv.display_name ? String(conv.display_name) : '') + ' ' + (conv.wa_id ? String(conv.wa_id) : '');
                    const preview = pickPreview(conv);
                    return (name + ' ' + preview).toLowerCase().indexOf(q) !== -1;
                });

                if (!filtered || filtered.length === 0) {
                    html = '<div class="wb-empty">' + escapeHtml(currentLocale.indexOf('ar') === 0 ? 'لا توجد محادثات بهذه الحالة' : 'No conversations for this status') + '</div>';
                } else {
                    filtered.forEach(function (conv) {
                        const isSelected = selectedId !== null && Number(conv.id) === Number(selectedId);
                        const name = conv.display_name ? conv.display_name : conv.wa_id;
                        const href = buildChatIndexUrl({ conversation_id: conv.id });
                        const time = formatTime(conv.last_message_at);
                        const preview = pickPreview(conv);
                        const unread = conv.unread_count ? Number(conv.unread_count) : 0;
                        const matchedMessage = conv.search_match_body ? String(conv.search_match_body) : '';

                        html += '<a href="' + href + '" class="wb-conv-item ' + (isSelected ? 'is-active' : '') + '" data-conversation-id="' + escapeHtml(conv.id) + '" data-wa-id="' + escapeHtml(conv.wa_id || '') + '" data-display-name="' + escapeHtml(conv.display_name || '') + '" data-profile-pic="' + escapeHtml(conv.profile_pic || '') + '">';
                        html += avatarHtml(conv.profile_pic, name);
                        html += '<div class="wb-conv-main">';
                        html += '<div class="wb-conv-top">';
                        html += '<div class="wb-conv-name">' + escapeHtml(name) + '</div>';
                        html += '<div class="wb-conv-time">' + escapeHtml(time) + '</div>';
                        html += '</div>';
                        html += '<div class="wb-conv-preview">';
                        html += '<div class="wb-conv-snippet">' + escapeHtml(preview) + '</div>';
                        if (unread > 0) {
                            html += '<div class="wb-unread">' + escapeHtml(unread) + '</div>';
                        }
                        html += '</div>';
                        if (conversationSearchTerm && matchedMessage) {
                            html += '<div class="wb-conv-search-match">' + highlightSearchMatch(matchedMessage) + '</div>';
                        }
                        html += '</div>';
                        html += '</a>';
                    });
                }
                $('.wb-conv-list').html(html);
            }

            function renderMessages(items) {
                function mediaTypeLabel(type) {
                    const value = type ? String(type) : 'text';
                    const ar = currentLocale.indexOf('ar') === 0;
                    if (value === 'image') return ar ? 'صورة' : 'Image';
                    if (value === 'video') return ar ? 'فيديو' : 'Video';
                    if (value === 'audio') return ar ? 'صوت' : 'Voice';
                    if (value === 'document') return '';
                    if (value === 'sticker') return ar ? 'ملصق' : 'Sticker';
                    return '';
                }

                function looksLikeFileName(value) {
                    const text = value ? String(value).trim() : '';
                    if (!text) return false;
                    return /^[^\\\/]+?\.[a-z0-9]{2,8}$/i.test(text);
                }

                let html = '';
                if (!items || items.length === 0) {
                    html = '<div class="wb-empty">' + (currentLocale.indexOf('ar') === 0 ? 'لا توجد رسائل' : 'No messages yet') + '</div>';
                } else {
                    const byWamid = {};
                    (items || []).forEach(function (m) {
                        if (m && m.wamid) {
                            byWamid[String(m.wamid)] = m;
                        }
                    });

                    function docFileName(msg) {
                        const raw = msg && msg.raw ? msg.raw : null;
                        const fromRaw = raw && raw.document && raw.document.filename ? String(raw.document.filename).trim() : '';
                        const fromUploaded = raw && raw.uploaded_media_name ? String(raw.uploaded_media_name).trim() : '';
                        const fromBody = msg && msg.body ? String(msg.body).trim() : '';
                        return fromRaw || fromUploaded || fromBody || (currentLocale.indexOf('ar') === 0 ? 'ملف' : 'File');
                    }

                    function fileExt(name) {
                        const text = name ? String(name) : '';
                        const idx = text.lastIndexOf('.');
                        if (idx < 0) return '';
                        const ext = text.slice(idx + 1).trim();
                        if (!ext) return '';
                        return ext.toUpperCase().slice(0, 8);
                    }

                    items.slice().reverse().forEach(function (msg) {
                        const isOut = msg.direction === 'out';
                        const time = formatTime(msg.wa_timestamp || msg.created_at);
                        const type = msg && msg.type ? String(msg.type) : 'text';
                        const normalizedType = String(type).trim().toLowerCase();
                        const label = (normalizedType === 'audio' || normalizedType === 'document') ? '' : mediaTypeLabel(type);
                        const originalBody = msg && msg.body ? String(msg.body) : '';
                        let body = originalBody;
                        const voicePlaceholder = currentLocale.indexOf('ar') === 0 ? 'رسالة صوتية' : 'Voice message';
                        const mediaSrc = messageMediaUrlTemplate && msg && msg.id !== undefined && msg.id !== null
                            ? String(messageMediaUrlTemplate).replace('__ID__', String(msg.id))
                            : '';
                        if (normalizedType !== 'document' && label && looksLikeFileName(body)) {
                            body = '';
                        }
                        if (normalizedType === 'document') {
                            const name = docFileName(msg);
                            const captionCandidate = originalBody ? String(originalBody).trim() : '';
                            body = (captionCandidate && captionCandidate !== name) ? captionCandidate : '';
                        }
                        if (normalizedType === 'audio' && !body) {
                            body = voicePlaceholder;
                        }
                        const raw = msg && msg.raw ? msg.raw : null;
                        const replyToWamid =
                            raw && raw.reply_to_message_id ? String(raw.reply_to_message_id) :
                                (raw && raw.context && raw.context.id ? String(raw.context.id) :
                                    (raw && raw.context && raw.context.message_id ? String(raw.context.message_id) : ''));
                        const replied = replyToWamid ? (byWamid[replyToWamid] || null) : null;
                        const isDeleted = msg && msg.message_status ? String(msg.message_status).trim().toLowerCase() === 'deleted' : false;
                        html += '<div class="wb-msg ' + (isOut ? 'wb-msg--out' : 'wb-msg--in') + '" data-message-id="' + escapeHtml(msg.id) + '">';
                        html += '<div class="wb-bubble">';
                        if (replyToWamid) {
                            const title = replied
                                ? (replied.direction === 'out'
                                    ? (currentLocale.indexOf('ar') === 0 ? 'أنت' : 'You')
                                    : (currentLocale.indexOf('ar') === 0 ? 'العميل' : 'Customer'))
                                : (currentLocale.indexOf('ar') === 0 ? 'رسالة' : 'Message');
                            const preview = replied
                                ? (replied.type && String(replied.type).trim().toLowerCase() !== 'text'
                                    ? mediaPreviewLabel(replied.type)
                                    : (replied.body ? String(replied.body) : ''))
                                : (currentLocale.indexOf('ar') === 0 ? 'الرسالة الأصلية غير متاحة' : 'Original message is not available');
                            html += '<div class="wb-reply-quote" data-action="jump" data-target-wamid="' + escapeHtml(replyToWamid) + '">';
                            html += '<div class="wb-reply-quote-title">' + escapeHtml(title) + '</div>';
                            html += '<div class="wb-reply-quote-body">' + escapeHtml(preview) + '</div>';
                            html += '</div>';
                        }
                        if (label) {
                            html += '<div class="wb-media-label">' + escapeHtml(label) + '</div>';
                        }
                        if (normalizedType === 'image' && mediaSrc) {
                            html += '<img class="wb-media-img" loading="lazy" src="' + escapeHtml(mediaSrc) + '" alt="Image">';
                        }
                        if (normalizedType === 'video' && mediaSrc) {
                            html += '<video class="wb-media-video" controls preload="metadata" playsinline><source src="' + escapeHtml(mediaSrc) + '"></video>';
                        }
                        if (normalizedType === 'audio' && mediaSrc) {
                            html += '<div class="wb-audio-row">';
                            html += '<button class="wb-audio-message-btn" type="button" data-action="play-audio" data-message-id="' + escapeHtml(msg.id) + '" data-audio-src="' + escapeHtml(mediaSrc) + '" data-audio-title="' + escapeHtml(audioPlayerTitleForCurrentConversation()) + '"><i class="fa fa-play"></i><span>' + escapeHtml(voicePlaceholder) + '</span></button>';
                            html += '<a class="wb-audio-dl-btn" href="' + escapeHtml(mediaSrc) + '?download=1" download title="' + (currentLocale.indexOf('ar') === 0 ? 'تحميل' : 'Download') + '"><i class="fa fa-download"></i></a>';
                            html += '</div>';
                        }
                        if (normalizedType === 'document') {
                            const name = docFileName(msg);
                            const ext = fileExt(name) || 'FILE';
                            const dl = mediaSrc ? (String(mediaSrc) + '?download=1') : '';
                            const mime = raw && raw.document && raw.document.mime_type ? String(raw.document.mime_type).trim() : (raw && raw.uploaded_media_mime ? String(raw.uploaded_media_mime).trim() : '');
                            html += '<div class="wb-doc">';
                            html += '<div class="wb-doc-icon">' + escapeHtml(ext) + '</div>';
                            html += '<div class="wb-doc-info">';
                            if (dl) {
                                html += '<a class="wb-doc-name" href="' + escapeHtml(dl) + '" target="_blank" rel="noopener">' + escapeHtml(name) + '</a>';
                            } else {
                                html += '<div class="wb-doc-name">' + escapeHtml(name) + '</div>';
                            }
                            html += '<div class="wb-doc-meta">' + escapeHtml(mime || ext) + '</div>';
                            html += '</div>';
                            if (dl) {
                                html += '<a class="wb-doc-action" href="' + escapeHtml(dl) + '" target="_blank" rel="noopener"><i class="fa fa-download"></i></a>';
                            }
                            html += '</div>';
                        }
                        if (isDeleted) {
                            html += '<div class="wb-text">' + escapeHtml(currentLocale.indexOf('ar') === 0 ? 'تم حذف هذه الرسالة' : 'This message was deleted') + '</div>';
                        } else if (normalizedType === 'text' || body) {
                            html += '<div class="wb-text">' + escapeHtml(body) + '</div>';
                        }
                        html += '<div class="wb-meta">';
                        html += '<span>' + escapeHtml(time) + '</span>';
                        html += '<span class="wb-msg-actions">';
                        const canReply = !!msg.wamid;
                        const replyTitle = canReply
                            ? (currentLocale.indexOf('ar') === 0 ? 'رد على هذه الرسالة' : 'Reply to this message')
                            : (currentLocale.indexOf('ar') === 0 ? 'الرد غير متاح لهذه الرسالة' : 'Reply not available for this message');
                        html += '<button class="wb-msg-action" type="button" data-action="reply" data-message-id="' + escapeHtml(msg.id) + '" title="' + replyTitle + '"' + (canReply ? '' : ' disabled') + '><i class="fa fa-reply"></i></button>';
                        if (isOut && !isDeleted) {
                            html += '<button class="wb-msg-action is-danger" type="button" data-action="delete" data-message-id="' + escapeHtml(msg.id) + '"><i class="fa fa-trash"></i></button>';
                        }
                        html += '</span>';
                        if (isOut) {
                            const statusMeta = getOutgoingStatusMeta(msg && msg.message_status ? msg.message_status : '');
                            html += '<span class="' + statusMeta.className + '">' + statusMeta.text + '</span>';
                        }
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    });
                }
                const box = $('.wb-messages');
                const atBottom = isFirstMessagesRender || (box[0].scrollHeight - box.scrollTop() - box.outerHeight()) < 60;
                box.html(html);
                syncGlobalAudioMessageButtons();
                if (atBottom) {
                    box.scrollTop(box[0].scrollHeight);
                    isFirstMessagesRender = false;
                }
            }

            function resetConversationsPagination() {
                conversationsNextOffset = 0;
                conversationsHasMore = true;
                conversationsLoadingMore = false;
            }

            function mergeConversations(existing, incoming) {
                const seen = {};
                const merged = [];
                (existing || []).concat(incoming || []).forEach(function (item) {
                    if (!item || item.id === undefined || item.id === null) return;
                    const key = String(item.id);
                    if (seen[key]) {
                        const idx = merged.findIndex(function (row) { return row && String(row.id) === key; });
                        if (idx !== -1) merged[idx] = item;
                        return;
                    }
                    seen[key] = true;
                    merged.push(item);
                });
                return merged;
            }

            function loadConversations(loadMore) {
                if (loadMore && (conversationsLoadingMore || !conversationsHasMore)) {
                    return $.Deferred().resolve().promise();
                }
                if (loadMore === false) {
                    resetConversationsPagination();
                }

                const requestedSearch = conversationSearchTerm;
                const requestedOffset = loadMore ? conversationsNextOffset : 0;
                const requestedLimit = loadMore ? 50 : Math.max(50, conversationsCache.length || 50);
                let continueSearchLoading = false;
                conversationsLoadingMore = true;
                return $.get(convUrl, { limit: requestedLimit, offset: requestedOffset, account_id: selectedAccountId, conversation_id: activeConversationId || '', status: currentStatusFilter || '', tag_id: currentTagFilter || '', search: requestedSearch })
                    .done(function (res) {
                        if (requestedSearch !== conversationSearchTerm) return;
                        if (res && res.data && res.data.items) {
                            conversationsCache = loadMore
                                ? mergeConversations(conversationsCache, res.data.items)
                                : res.data.items;
                            const pagination = res.data.pagination || {};
                            conversationsHasMore = !!pagination.has_more;
                            conversationsNextOffset = pagination.next_offset !== null && pagination.next_offset !== undefined
                                ? Number(pagination.next_offset)
                                : conversationsCache.length;
                            continueSearchLoading = requestedSearch !== '' && conversationsHasMore;
                            const q = $('#wb-chat-search').val();
                            renderConversations(conversationsCache, q);
                        }
                    })
                    .always(function () {
                        conversationsLoadingMore = false;
                        if (continueSearchLoading && requestedSearch === conversationSearchTerm) {
                            window.setTimeout(function () {
                                loadConversations(true);
                            }, 0);
                        }
                    });
            }

            function mergeMessages(existing, incoming) {
                const byId = {};
                (existing || []).concat(incoming || []).forEach(function (item) {
                    if (!item || item.id === undefined || item.id === null) return;
                    byId[String(item.id)] = item;
                });
                return Object.keys(byId).map(function (key) { return byId[key]; }).sort(function (a, b) {
                    return Number(b.id) - Number(a.id);
                });
            }

            function loadMessages(loadOlder) {
                if (activeConversationId === null) return $.Deferred().resolve().promise();
                if (loadOlder && (messagesLoadingOlder || !messagesHasMore || !messagesNextBeforeId)) {
                    return $.Deferred().resolve().promise();
                }
                const requestedConversationId = activeConversationId;
                const url = msgUrlTemplate.replace('__ID__', requestedConversationId);
                const requestedBeforeId = loadOlder ? messagesNextBeforeId : null;
                if (loadOlder) messagesLoadingOlder = true;
                const box = document.querySelector('.wb-messages');
                const oldScrollHeight = box ? box.scrollHeight : 0;
                const oldScrollTop = box ? box.scrollTop : 0;
                return $.get(url, { limit: 50, before_id: requestedBeforeId || undefined })
                    .done(function (res) {
                        if (activeConversationId !== requestedConversationId) return;
                        if (res && res.data && res.data.items) {
                            const nextMessages = mergeMessages(messagesCache, res.data.items);
                            messagesHasMore = !!res.data.has_more;
                            messagesNextBeforeId = res.data.next_before_id ? Number(res.data.next_before_id) : null;
                            const nextSignature = nextMessages.map(function (message) {
                                return [
                                    message.id,
                                    message.wamid,
                                    message.type,
                                    message.body,
                                    message.message_status,
                                    message.updated_at,
                                    message.wa_timestamp
                                ].join('|');
                            }).join('||');

                            // Polling continues to fetch new messages, but does not recreate the
                            // message DOM when nothing changed. This keeps a manually played video
                            // in its current state instead of stopping it every few seconds.
                            if (nextSignature === messagesSignature) return;
                            messagesSignature = nextSignature;
                            messagesCache = nextMessages;
                            renderMessages(messagesCache);
                            if (loadOlder && box) {
                                box.scrollTop = oldScrollTop + (box.scrollHeight - oldScrollHeight);
                            }
                        }
                    })
                    .always(function () {
                        messagesLoadingOlder = false;
                    });
            }

            function bindMessagesPagination() {
                const box = document.querySelector('.wb-messages');
                if (!box) return;
                box.addEventListener('scroll', function () {
                    if (box.scrollTop > 160 || !messagesHasMore || messagesLoadingOlder) return;
                    loadMessages(true);
                }, { passive: true });
            }

            function tick() {
                if (isLoading) return;
                isLoading = true;
                $.when(loadConversations(), loadMessages(), loadMeta())
                    .always(function () {
                        isLoading = false;
                    });
            }

            function bindSearch() {
                const input = document.getElementById('wb-chat-search');
                if (!input) return;
                let searchTimer = null;
                input.addEventListener('input', function () {
                    conversationSearchTerm = String(input.value || '').trim();
                    if (searchTimer) window.clearTimeout(searchTimer);
                    searchTimer = window.setTimeout(function () {
                        loadConversations(false);
                    }, 250);
                });
            }

            function bindConversationsPagination() {
                const list = document.querySelector('.wb-conv-list');
                if (!list) return;
                list.addEventListener('scroll', function () {
                    if (!conversationsHasMore || conversationsLoadingMore) return;
                    const remaining = list.scrollHeight - list.scrollTop - list.clientHeight;
                    if (remaining > 160) return;
                    loadConversations(true);
                }, { passive: true });
            }

            function bindConversationSelection() {
                const list = document.querySelector('.wb-conv-list');
                if (!list) return;

                list.addEventListener('click', function (event) {
                    const link = event.target && event.target.closest ? event.target.closest('a.wb-conv-item') : null;
                    if (!link || !list.contains(link)) return;

                    let conversationId = null;
                    try {
                        conversationId = new URL(link.href, window.location.origin).searchParams.get('conversation_id');
                    } catch (e) {
                        conversationId = null;
                    }
                    if (!conversationId) return;

                    event.preventDefault();
                    const selected = (conversationsCache || []).find(function (item) {
                        return item && Number(item.id) === Number(conversationId);
                    }) || {
                        id: conversationId,
                        wa_id: link.dataset.waId || '',
                        display_name: link.dataset.displayName || '',
                        profile_pic: link.dataset.profilePic || ''
                    };
                    selectConversation(conversationId, selected, true);
                });

                window.addEventListener('popstate', function () {
                    const conversationId = getUrlConversationId();
                    if (!conversationId || Number(conversationId) === activeConversationId) return;
                    const selected = (conversationsCache || []).find(function (item) {
                        return item && Number(item.id) === Number(conversationId);
                    });
                    selectConversation(conversationId, selected || {}, false);
                });
            }

            function bindConversationTabs() {
                const tabsContainer = document.getElementById('wb-conversation-tabs');
                const tabs = Array.from(document.querySelectorAll('[data-conversation-filter]'));
                if (!tabs.length) return;

                if (tabsContainer) {
                    tabsContainer.addEventListener('wheel', function (event) {
                        if (tabsContainer.scrollWidth <= tabsContainer.clientWidth) return;
                        const movement = Math.abs(event.deltaX) > Math.abs(event.deltaY)
                            ? event.deltaX
                            : event.deltaY;
                        if (!movement) return;
                        event.preventDefault();
                        tabsContainer.scrollLeft += movement;
                    }, { passive: false });
                }

                function updateTabs() {
                    tabs.forEach(function (tab) {
                        const active = tab.getAttribute('data-conversation-filter') === currentConversationFilter;
                        tab.classList.toggle('is-active', active);
                        tab.setAttribute('aria-selected', active ? 'true' : 'false');
                        tab.setAttribute('tabindex', active ? '0' : '-1');
                    });
                }

                updateTabs();

                tabs.forEach(function (tab) {
                    tab.addEventListener('click', function () {
                        const nextFilter = tab.getAttribute('data-conversation-filter') || 'all';
                        if (nextFilter === currentConversationFilter) return;

                        currentConversationFilter = nextFilter;
                        currentStatusFilter = nextFilter === 'open'
                            ? 'open'
                            : (nextFilter === 'closed' ? 'resolved' : '');
                        currentTagFilter = '';
                        root.dataset.currentStatusFilter = currentStatusFilter;
                        root.dataset.currentTagFilter = '';
                        updateTabs();

                        const list = document.querySelector('.wb-conv-list');
                        if (list) {
                            list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.loading) + '</div>';
                        }

                        if (chatIndexUrl && window.history && typeof window.history.replaceState === 'function') {
                            const nextUrl = buildChatIndexUrl({
                                filter: currentConversationFilter === 'all' ? null : currentConversationFilter,
                                status: currentStatusFilter || null,
                                tag_id: null,
                                conversation_id: null,
                                wa_id: null
                            });
                            window.history.replaceState(null, '', nextUrl);
                        }

                        loadConversations(false);
                    });
                });
            }

            function bindTypingIndicator() {
                const input = document.getElementById('wb-composer-input');
                const typing = document.getElementById('wb-typing-indicator');
                if (!input || !typing) return;

                let t = null;
                input.addEventListener('input', function () {
                    if (!input.value || !input.value.trim()) {
                        typing.style.display = 'none';
                        return;
                    }
                    typing.style.display = 'block';
                    if (t) clearTimeout(t);
                    t = setTimeout(function () {
                        typing.style.display = 'none';
                    }, 900);
                });
            }

            function openQuickRepliesPanel() {
                const panel = document.getElementById('wb-qr-panel');
                if (!panel) return;
                panel.style.display = '';
                const search = document.getElementById('wb-qr-search');
                if (search) {
                    search.value = '';
                    search.focus();
                }
                renderQuickRepliesList(quickRepliesCache, '');
                loadQuickReplies(false);
            }

            function closeQuickRepliesPanel() {
                const panel = document.getElementById('wb-qr-panel');
                if (!panel) return;
                panel.style.display = 'none';
            }

            function renderQuickRepliesList(items, query) {
                const list = document.getElementById('wb-qr-list');
                if (!list) return;
                const q = query ? String(query).trim().toLowerCase() : '';
                const filtered = (items || []).filter(function (it) {
                    if (!q) return true;
                    const t = (it.title ? String(it.title) : '') + ' ' + (it.shortcut ? String(it.shortcut) : '') + ' ' + (it.body ? String(it.body) : '');
                    return t.toLowerCase().indexOf(q) !== -1;
                }).slice(0, 20);

                if (!filtered || filtered.length === 0) {
                    list.innerHTML = '<div class="wb-empty">' + (currentLocale.indexOf('ar') === 0 ? 'لا توجد ردود سريعة' : 'No quick replies') + '</div>';
                    return;
                }

                let html = '';
                filtered.forEach(function (it) {
                    const id = Number(it.id);
                    const title = it && it.title ? String(it.title) : '';
                    const shortcut = it && it.shortcut ? String(it.shortcut) : '';
                    const body = it && it.body ? String(it.body) : '';
                    html += '<div class="wb-qr-item" data-qr-id="' + escapeHtml(id) + '">';
                    html += '<div class="wb-qr-title">';
                    if (shortcut) {
                        html += '<span class="wb-qr-shortcut">' + escapeHtml(shortcut) + '</span>';
                    }
                    html += '<span>' + escapeHtml(title) + '</span>';
                    html += '</div>';
                    html += '<div class="wb-qr-body">' + escapeHtml(body) + '</div>';
                    html += '</div>';
                });
                list.innerHTML = html;
            }

            function loadQuickReplies(force) {
                if (!quickRepliesUrl) return;
                if (quickRepliesLoaded && !force) return;
                $.get(quickRepliesUrl, { limit: 200 })
                    .done(function (res) {
                        quickRepliesCache = res && res.data && res.data.items ? res.data.items : [];
                        quickRepliesLoaded = true;
                        const search = document.getElementById('wb-qr-search');
                        renderQuickRepliesList(quickRepliesCache, search ? search.value : '');
                    })
                    .fail(function () {
                        const list = document.getElementById('wb-qr-list');
                        if (list) list.innerHTML = '<div class="wb-empty">' + (currentLocale.indexOf('ar') === 0 ? 'حصل خطأ أثناء تحميل الردود السريعة' : 'Failed to load quick replies') + '</div>';
                    });
            }

            function sendMessageAjax(text) {
                if (!sendMessageUrl || activeConversationId === null) return $.Deferred().reject().promise();
                const toInput = document.querySelector('form.wb-composer-form input[name="to"]');
                const to = toInput ? String(toInput.value || '').trim() : '';
                const body = String(text || '').trim();
                if (!to || !body) return $.Deferred().reject().promise();
                const replyToInput = document.querySelector('form.wb-composer-form input[name="reply_to_wamid"]');
                const replyTo = replyToInput ? String(replyToInput.value || '').trim() : '';
                return $.ajax({
                    url: sendMessageUrl,
                    type: 'POST',
                    data: { account_id: selectedAccountId, to: to, message: body, reply_to_wamid: replyTo }
                });
            }

            function sendMediaAjax(file, caption, forceType) {
                if (!mediaUrl || activeConversationId === null) return $.Deferred().reject().promise();
                const toInput = document.querySelector('form.wb-composer-form input[name="to"]');
                const to = toInput ? String(toInput.value || '').trim() : '';
                if (!to || !file) return $.Deferred().reject().promise();
                const replyToInput = document.querySelector('form.wb-composer-form input[name="reply_to_wamid"]');
                const replyTo = replyToInput ? String(replyToInput.value || '').trim() : '';

                const fd = new FormData();
                fd.append('account_id', String(selectedAccountId));
                fd.append('to', to);
                fd.append('file', file);
                if (caption && String(caption).trim()) {
                    fd.append('caption', String(caption).trim());
                }
                if (forceType) {
                    fd.append('force_type', String(forceType));
                }
                if (replyTo) {
                    fd.append('reply_to_wamid', replyTo);
                }

                return $.ajax({
                    url: mediaUrl,
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false
                });
            }

            function buildOptimisticMediaMessage(file, caption, forceType) {
                const normalizedType = forceType
                    ? String(forceType).trim().toLowerCase()
                    : (file && file.type ? String(file.type).toLowerCase() : '');
                let type = 'document';
                if (normalizedType === 'audio' || normalizedType.indexOf('audio/') === 0) {
                    type = 'audio';
                } else if (normalizedType === 'image' || normalizedType.indexOf('image/') === 0) {
                    type = 'image';
                } else if (normalizedType === 'video' || normalizedType.indexOf('video/') === 0) {
                    type = 'video';
                }

                const trimmedCaption = caption && String(caption).trim() ? String(caption).trim() : '';
                let body = trimmedCaption || null;
                if (type === 'document' && !body && file && file.name) {
                    body = String(file.name);
                }

                return {
                    id: 'temp_' + Date.now() + '_' + Math.random().toString(36).slice(2, 8),
                    conversation_id: activeConversationId,
                    direction: 'out',
                    type: type,
                    message_status: 'uploading',
                    body: body,
                    created_at: new Date().toISOString(),
                    wa_timestamp: null,
                    sender_admin_name: '',
                    raw: (function () {
                        const replyToInput = document.querySelector('form.wb-composer-form input[name="reply_to_wamid"]');
                        const replyTo = replyToInput ? String(replyToInput.value || '').trim() : '';
                        return replyTo ? { reply_to_message_id: replyTo } : null;
                    })(),
                    __temp: true,
                };
            }

            function setReplyToMessage(msg) {
                if (!msg) return;
                const wamid = msg && msg.wamid ? String(msg.wamid).trim() : '';
                if (!wamid) {
                    showInfoDialog(currentLocale.indexOf('ar') === 0
                        ? 'لا يمكن الرد على هذه الرسالة — معرّف الرسالة غير متوفر.'
                        : 'Cannot reply to this message — message ID is not available.');
                    return;
                }

                currentReplyToWamid = wamid;
                const input = document.querySelector('form.wb-composer-form input[name="reply_to_wamid"]');
                if (input) input.value = currentReplyToWamid;

                const bar = document.getElementById('wb-reply-bar');
                const titleEl = document.getElementById('wb-reply-title');
                const snippetEl = document.getElementById('wb-reply-snippet');
                if (titleEl) {
                    titleEl.textContent = msg.direction === 'out'
                        ? (currentLocale.indexOf('ar') === 0 ? 'رد على: أنت' : 'Reply to: You')
                        : (currentLocale.indexOf('ar') === 0 ? 'رد على: العميل' : 'Reply to: Customer');
                }
                if (snippetEl) {
                    const preview = msg.type && String(msg.type).trim().toLowerCase() !== 'text'
                        ? mediaPreviewLabel(msg.type)
                        : (msg.body ? String(msg.body) : '');
                    snippetEl.textContent = preview || (currentLocale.indexOf('ar') === 0 ? 'رسالة' : 'Message');
                }
                if (bar) bar.style.display = '';

                focusComposerIfDesktop();
            }

            function clearReplyToMessage() {
                currentReplyToWamid = '';
                const input = document.querySelector('form.wb-composer-form input[name="reply_to_wamid"]');
                if (input) input.value = '';
                const bar = document.getElementById('wb-reply-bar');
                if (bar) bar.style.display = 'none';
            }

            function bindReplyBar() {
                const closeBtn = document.getElementById('wb-reply-close');
                if (closeBtn) closeBtn.addEventListener('click', clearReplyToMessage);
            }

            function getGlobalAudioElements() {
                return {
                    wrap: document.getElementById('wb-audio-player'),
                    audio: document.getElementById('wb-global-audio'),
                    title: document.getElementById('wb-audio-player-title'),
                    close: document.getElementById('wb-audio-player-close'),
                    speedBtns: document.querySelectorAll('.wb-audio-speed-btn')
                };
            }

            function syncGlobalAudioMessageButtons() {
                const els = getGlobalAudioElements();
                const activeMessageId = els.audio ? els.audio.dataset.messageId || '' : '';
                const isPlaying = els.audio ? !els.audio.paused && !els.audio.ended : false;
                document.querySelectorAll('.wb-audio-message-btn[data-message-id]').forEach(function (button) {
                    const active = activeMessageId && button.getAttribute('data-message-id') === activeMessageId;
                    button.classList.toggle('is-active', !!active);
                    const icon = button.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-play', !(active && isPlaying));
                        icon.classList.toggle('fa-pause', active && isPlaying);
                    }
                });
            }

            function playAudioInGlobalPlayer(messageId, src, title) {
                const els = getGlobalAudioElements();
                if (!els.wrap || !els.audio || !src) return;
                const nextMessageId = String(messageId || '');
                const nextSrc = String(src || '');
                const isSameAudio = els.audio.dataset.messageId === nextMessageId && els.audio.getAttribute('src') === nextSrc;

                els.wrap.classList.add('is-visible');
                if (els.title) {
                    els.title.textContent = title || audioPlayerTitleForCurrentConversation();
                }

                if (isSameAudio) {
                    if (els.audio.paused || els.audio.ended) {
                        const promise = els.audio.play();
                        if (promise && typeof promise.catch === 'function') promise.catch(function () { });
                    } else {
                        els.audio.pause();
                    }
                    syncGlobalAudioMessageButtons();
                    return;
                }

                els.audio.dataset.messageId = nextMessageId;
                els.audio.setAttribute('src', nextSrc);
                els.audio.playbackRate = parseFloat(localStorage.getItem('wb_audio_speed') || '1') || 1;
                if (els.speedBtns) {
                    els.speedBtns.forEach(function (btn) {
                        btn.classList.toggle('is-active', parseFloat(btn.getAttribute('data-speed')) === els.audio.playbackRate);
                    });
                }
                els.audio.load();
                const promise = els.audio.play();
                if (promise && typeof promise.catch === 'function') promise.catch(function () { });
                syncGlobalAudioMessageButtons();
            }

            function closeGlobalAudioPlayer() {
                const els = getGlobalAudioElements();
                if (!els.wrap || !els.audio) return;
                els.audio.pause();
                els.audio.removeAttribute('src');
                els.audio.dataset.messageId = '';
                els.audio.load();
                els.wrap.classList.remove('is-visible');
                syncGlobalAudioMessageButtons();
            }

            function bindGlobalAudioPlayer() {
                const els = getGlobalAudioElements();
                if (!els.audio) return;
                ['play', 'pause', 'ended'].forEach(function (eventName) {
                    els.audio.addEventListener(eventName, syncGlobalAudioMessageButtons);
                });
                if (els.close) {
                    els.close.addEventListener('click', closeGlobalAudioPlayer);
                }
                if (els.speedBtns && els.speedBtns.length) {
                    els.speedBtns.forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            const speed = parseFloat(btn.getAttribute('data-speed')) || 1;
                            els.audio.playbackRate = speed;
                            localStorage.setItem('wb_audio_speed', String(speed));
                            els.speedBtns.forEach(function (b) {
                                b.classList.toggle('is-active', parseFloat(b.getAttribute('data-speed')) === speed);
                            });
                        });
                    });
                    const saved = parseFloat(localStorage.getItem('wb_audio_speed') || '1') || 1;
                    els.audio.playbackRate = saved;
                    els.speedBtns.forEach(function (b) {
                        b.classList.toggle('is-active', parseFloat(b.getAttribute('data-speed')) === saved);
                    });
                }
            }

            function bindMessageActions() {
                const box = document.querySelector('.wb-messages');
                if (!box) return;
                box.addEventListener('click', function (e) {
                    const target = e.target && e.target.closest ? e.target.closest('[data-action]') : null;
                    if (!target) return;
                    const action = target.getAttribute('data-action');
                    if (action === 'play-audio') {
                        playAudioInGlobalPlayer(
                            target.getAttribute('data-message-id'),
                            target.getAttribute('data-audio-src'),
                            target.getAttribute('data-audio-title')
                        );
                        return;
                    }
                    if (action === 'reply') {
                        if (target.disabled || target.hasAttribute('disabled')) return;
                        const messageId = target.getAttribute('data-message-id');
                        if (!messageId) return;
                        const msg = (messagesCache || []).find(function (m) { return m && String(m.id) === String(messageId); });
                        if (!msg) return;
                        setReplyToMessage(msg);
                        return;
                    }
                    if (action === 'jump') {
                        const wamid = target.getAttribute('data-target-wamid');
                        if (!wamid) return;
                        const msg = (messagesCache || []).find(function (m) { return m && m.wamid && String(m.wamid) === String(wamid); });
                        if (msg && msg.id !== undefined && msg.id !== null) {
                            highlightMessageById(msg.id);
                        } else {
                            showInfoDialog(currentLocale.indexOf('ar') === 0 ? 'الرسالة الأصلية غير متاحة ضمن الرسائل المعروضة.' : 'Original message is not available in the loaded messages.');
                        }
                        return;
                    }
                    if (action === 'delete') {
                        const messageId = target.getAttribute('data-message-id');
                        if (!messageId || !deleteMessageUrlTemplate) return;
                        const confirmText = currentLocale.indexOf('ar') === 0 ? 'هل تريد حذف هذه الرسالة؟' : 'Delete this message?';
                        if (!confirm(confirmText)) return;
                        const url = String(deleteMessageUrlTemplate).replace('__ID__', String(messageId));
                        $.ajax({ url: url, type: 'DELETE' })
                            .done(function (res) {
                                const idx = (messagesCache || []).findIndex(function (m) { return m && String(m.id) === String(messageId); });
                                if (idx !== -1) {
                                    const next = $.extend({}, messagesCache[idx], { message_status: 'deleted' });
                                    messagesCache = messagesCache.slice();
                                    messagesCache[idx] = next;
                                    renderMessages(messagesCache);
                                } else {
                                    tick();
                                }

                                const remoteDeleted = !!(res && res.data && res.data.remote_deleted);
                                if (!remoteDeleted) {
                                    showInfoDialog(currentLocale.indexOf('ar') === 0
                                        ? 'تم حذف الرسالة من لوحة التحكم فقط. WhatsApp Cloud API لا يدعم حذف الرسالة عند العميل.'
                                        : 'Message deleted in dashboard only. WhatsApp Cloud API does not support deleting it for the customer.');
                                }
                            })
                            .fail(function (xhr) {
                                const msg = getAjaxErrorMessage(xhr);
                                showErrorDialog(msg);
                            });
                    }
                });
            }

            function upsertOptimisticMessage(message) {
                const items = Array.isArray(messagesCache) ? messagesCache.slice() : [];
                const existingIndex = items.findIndex(function (item) {
                    return item && String(item.id) === String(message.id);
                });

                if (existingIndex === -1) {
                    items.unshift(message);
                } else {
                    items[existingIndex] = $.extend({}, items[existingIndex], message);
                }

                messagesCache = items;
                renderMessages(messagesCache);
            }

            function removeOptimisticMessage(messageId) {
                if (!Array.isArray(messagesCache) || !messagesCache.length) {
                    return;
                }

                messagesCache = messagesCache.filter(function (item) {
                    return item && String(item.id) !== String(messageId);
                });
                renderMessages(messagesCache);
            }

            function getAjaxErrorMessage(xhr) {
                if (!xhr) return currentLocale.indexOf('ar') === 0 ? 'حدث خطأ' : 'Something went wrong';

                const res = xhr.responseJSON;
                if (res) {
                    if (res.message) return String(res.message);
                    if (res.errors && typeof res.errors === 'object') {
                        const keys = Object.keys(res.errors);
                        if (keys.length > 0 && Array.isArray(res.errors[keys[0]]) && res.errors[keys[0]][0]) {
                            return String(res.errors[keys[0]][0]);
                        }
                    }
                    if (res.data && typeof res.data === 'object') {
                        const keys = Object.keys(res.data);
                        if (keys.length > 0 && Array.isArray(res.data[keys[0]]) && res.data[keys[0]][0]) {
                            return String(res.data[keys[0]][0]);
                        }
                    }
                }

                const text = xhr.responseText ? String(xhr.responseText) : '';
                if (text) {
                    try {
                        const parsed = JSON.parse(text);
                        if (parsed && parsed.message) return String(parsed.message);
                    } catch (e) {
                    }
                }

                return currentLocale.indexOf('ar') === 0 ? 'تعذر إرسال الرسالة. حاول مرة أخرى.' : 'Could not send the message. Please try again.';
            }

            function showComposerError(msg) {
                const el = document.getElementById('wb-composer-error');
                if (!el) return;
                const text = String(msg || '').trim();
                if (!text) {
                    el.textContent = '';
                    el.style.display = 'none';
                    return;
                }
                el.textContent = text;
                el.style.display = '';
            }

            function showErrorDialog(msg) {
                const text = String(msg || '').trim() || (currentLocale.indexOf('ar') === 0 ? 'حدث خطأ' : 'Something went wrong');
                if (typeof Swal !== 'undefined' && Swal && typeof Swal.fire === 'function') {
                    Swal.fire({
                        icon: 'error',
                        title: currentLocale.indexOf('ar') === 0 ? 'خطأ' : 'Error',
                        text: text,
                        confirmButtonText: currentLocale.indexOf('ar') === 0 ? 'حسنا' : 'OK',
                    });
                    return;
                }
                if (typeof errorToster === 'function') {
                    errorToster(currentLocale.indexOf('ar') === 0 ? 'خطأ' : 'Error', text);
                }
            }

            function bindComposerTools() {
                const button = document.getElementById('wb-composer-tools-btn');
                const menu = document.getElementById('wb-composer-tools-menu');
                const imageBtn = document.getElementById('wb-image-btn');
                const fileInput = document.getElementById('wb-file-input');
                if (!button || !menu) return;

                function setOpen(open) {
                    menu.classList.toggle('is-open', open);
                    menu.setAttribute('aria-hidden', open ? 'false' : 'true');
                    button.classList.toggle('is-open', open);
                    button.setAttribute('aria-expanded', open ? 'true' : 'false');
                }

                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    if (button.disabled) return;
                    setOpen(!menu.classList.contains('is-open'));
                });

                if (imageBtn && fileInput) {
                    imageBtn.addEventListener('click', function () {
                        if (imageBtn.disabled) return;
                        fileInput.value = '';
                        fileInput.setAttribute('accept', 'image/*,video/*');
                        fileInput.click();
                    });
                }

                menu.addEventListener('click', function (event) {
                    if (event.target && event.target.closest && event.target.closest('.wb-composer-tool')) {
                        setOpen(false);
                    }
                });

                document.addEventListener('click', function (event) {
                    if (!menu.classList.contains('is-open')) return;
                    const inside = event.target && event.target.closest
                        ? event.target.closest('#wb-composer-tools-btn, #wb-composer-tools-menu')
                        : null;
                    if (!inside) setOpen(false);
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') setOpen(false);
                });
            }

            function bindAttachments() {
                const attachBtn = document.getElementById('wb-attach-btn');
                const imageBtn = document.getElementById('wb-image-btn');
                const toolsBtn = document.getElementById('wb-composer-tools-btn');
                const audioBtn = document.getElementById('wb-audio-btn');
                const fileInput = document.getElementById('wb-file-input');
                const input = document.getElementById('wb-composer-input');
                const recordingIndicator = document.getElementById('wb-recording-indicator');
                const cancelRecordBtn = document.getElementById('wb-recording-cancel-btn');

                const qrBtn = document.getElementById('wb-qr-btn');
                const sendBtn = document.querySelector('form.wb-composer-form button[type="submit"]');
                const audioIcon = audioBtn ? audioBtn.querySelector('i') : null;
                let uploadBusy = false;
                let isRecordingAudio = false;
                let audioRecorder = null;
                let audioStream = null;
                let audioChunks = [];
                let audioMimeType = '';
                // lamejs MP3 state
                let audioCtx = null;
                let audioScriptNode = null;
                let audioSourceNode = null;
                let mp3Encoder = null;
                let mp3Chunks = [];
                let recordingStartTime = 0;
                let recordingTimerInterval = null;

                function formatRecordingDuration(seconds) {
                    const mins = Math.floor(seconds / 60);
                    const secs = Math.floor(seconds % 60);
                    return (mins < 10 ? '0' + mins : mins) + ':' + (secs < 10 ? '0' + secs : secs);
                }

                function startRecordingTimer() {
                    recordingStartTime = Date.now();
                    const timerEl = document.getElementById('wb-recording-timer');
                    if (timerEl) timerEl.textContent = '00:00';
                    if (recordingTimerInterval) {
                        clearInterval(recordingTimerInterval);
                    }
                    recordingTimerInterval = setInterval(function () {
                        const elapsed = Math.floor((Date.now() - recordingStartTime) / 1000);
                        if (timerEl) timerEl.textContent = formatRecordingDuration(elapsed);
                    }, 500);
                }

                function stopRecordingTimer() {
                    if (recordingTimerInterval) {
                        clearInterval(recordingTimerInterval);
                        recordingTimerInterval = null;
                    }
                    const timerEl = document.getElementById('wb-recording-timer');
                    if (timerEl) timerEl.textContent = '00:00';
                }

                function setBusy(busy) {
                    uploadBusy = !!busy;
                    const disableInputs = uploadBusy || isRecordingAudio;

                    if (disableInputs) {
                        if (input) input.setAttribute('disabled', 'disabled');
                        if (attachBtn) attachBtn.setAttribute('disabled', 'disabled');
                        if (imageBtn) imageBtn.setAttribute('disabled', 'disabled');
                        if (toolsBtn) toolsBtn.setAttribute('disabled', 'disabled');
                    } else {
                        if (input) input.removeAttribute('disabled');
                        if (attachBtn && activeConversationId !== null) attachBtn.removeAttribute('disabled');
                        if (imageBtn && activeConversationId !== null) imageBtn.removeAttribute('disabled');
                        if (toolsBtn && activeConversationId !== null) toolsBtn.removeAttribute('disabled');
                    }

                    if (qrBtn) {
                        if (disableInputs || activeConversationId === null) {
                            qrBtn.setAttribute('disabled', 'disabled');
                        } else {
                            qrBtn.removeAttribute('disabled');
                        }
                    }

                    if (sendBtn) {
                        if (disableInputs || activeConversationId === null) {
                            sendBtn.setAttribute('disabled', 'disabled');
                        } else {
                            sendBtn.removeAttribute('disabled');
                        }
                    }

                    if (audioBtn) {
                        if (activeConversationId === null || uploadBusy) {
                            audioBtn.setAttribute('disabled', 'disabled');
                        } else {
                            audioBtn.removeAttribute('disabled');
                        }
                    }
                }

                function updateAudioButtonUi() {
                    if (!audioBtn) return;
                    const indicator = document.getElementById('wb-recording-indicator');
                    if (isRecordingAudio) {
                        audioBtn.classList.add('is-recording');
                        audioBtn.setAttribute('title', currentLocale.indexOf('ar') === 0 ? 'إيقاف وإرسال التسجيل' : 'Stop & send recording');
                        if (audioIcon) {
                            audioIcon.className = 'fa fa-paper-plane';
                        }
                        if (input) input.style.display = 'none';
                        if (toolsBtn) toolsBtn.style.display = 'none';
                        if (sendBtn) sendBtn.style.display = 'none';
                        if (indicator) {
                            indicator.style.display = 'flex';
                            indicator.classList.add('is-visible');
                        }
                        return;
                    }

                    audioBtn.classList.remove('is-recording');
                    audioBtn.setAttribute('title', currentLocale.indexOf('ar') === 0 ? 'تسجيل صوتي' : 'Voice record');
                    if (audioIcon) {
                        audioIcon.className = 'fa fa-microphone';
                    }
                    if (input) input.style.display = '';
                    if (toolsBtn) toolsBtn.style.display = '';
                    if (sendBtn) sendBtn.style.display = '';
                    if (indicator) {
                        indicator.style.display = 'none';
                        indicator.classList.remove('is-visible');
                    }
                }

                function stopAudioTracks() {
                    if (!audioStream) return;
                    audioStream.getTracks().forEach(function (track) {
                        try {
                            track.stop();
                        } catch (e) {
                        }
                    });
                    audioStream = null;
                }

                function finishRecordedAudioUpload(blob) {
                    if (!blob || !blob.size) {
                        const msg = currentLocale.indexOf('ar') === 0 ? 'لم يتم تسجيل أي صوت. حاول مرة أخرى.' : 'No audio was recorded.';
                        showComposerError(msg);
                        showErrorDialog(msg);
                        return;
                    }

                    const file = new File([blob], 'voice_' + Date.now() + '.mp3', { type: 'audio/mpeg' });
                    const optimisticMessage = buildOptimisticMediaMessage(file, null, 'audio');
                    showComposerError('');
                    setBusy(true);
                    upsertOptimisticMessage(optimisticMessage);

                    sendMediaAjax(file, null, 'audio')
                        .done(function () {
                            upsertOptimisticMessage($.extend({}, optimisticMessage, {
                                message_status: 'sending',
                            }));
                            clearReplyToMessage();
                            tick();
                        })
                        .fail(function (xhr) {
                            removeOptimisticMessage(optimisticMessage.id);
                            const msg = getAjaxErrorMessage(xhr);
                            showComposerError(msg);
                            showErrorDialog(msg);
                        })
                        .always(function () {
                            setBusy(false);
                            focusComposerIfDesktop(input);
                        });
                }

                function cancelAudioRecording() {
                    if (!isRecordingAudio) return;
                    if (audioScriptNode) {
                        try { audioScriptNode.disconnect(); } catch (e) { }
                        audioScriptNode = null;
                    }
                    if (audioSourceNode) {
                        try { audioSourceNode.disconnect(); } catch (e) { }
                        audioSourceNode = null;
                    }
                    if (audioCtx) {
                        try { audioCtx.close(); } catch (e) { }
                        audioCtx = null;
                    }
                    mp3Encoder = null;
                    mp3Chunks = [];
                    stopRecordingTimer();
                    isRecordingAudio = false;
                    stopAudioTracks();
                    updateAudioButtonUi();
                    setBusy(uploadBusy);
                }
                window.__cancelAudioRecording = cancelAudioRecording;

                function stopAudioRecording() {
                    if (audioScriptNode) {
                        try { audioScriptNode.disconnect(); } catch (e) { }
                        audioScriptNode = null;
                    }
                    if (audioSourceNode) {
                        try { audioSourceNode.disconnect(); } catch (e) { }
                        audioSourceNode = null;
                    }

                    var blob = null;
                    if (mp3Encoder) {
                        var endBuf = mp3Encoder.flush();
                        if (endBuf && endBuf.length > 0) mp3Chunks.push(new Uint8Array(endBuf));
                        var totalLen = mp3Chunks.reduce(function (a, c) { return a + c.length; }, 0);
                        if (totalLen > 0) {
                            var mp3Data = new Uint8Array(totalLen);
                            var off = 0;
                            for (var i = 0; i < mp3Chunks.length; i++) {
                                mp3Data.set(mp3Chunks[i], off);
                                off += mp3Chunks[i].length;
                            }
                            blob = new Blob([mp3Data], { type: 'audio/mpeg' });
                        }
                        mp3Encoder = null;
                        mp3Chunks = [];
                    }

                    if (audioCtx) {
                        try { audioCtx.close(); } catch (e) { }
                        audioCtx = null;
                    }

                    stopRecordingTimer();
                    isRecordingAudio = false;
                    updateAudioButtonUi();
                    setBusy(uploadBusy);
                    stopAudioTracks();

                    if (blob && blob.size > 0) {
                        finishRecordedAudioUpload(blob);
                    } else {
                        const noAudioMsg = currentLocale.indexOf('ar') === 0 ? 'لم يتم تسجيل أي صوت.' : 'No audio was recorded.';
                        showComposerError(noAudioMsg);
                    }
                }

                function startAudioRecording() {
                    if (!navigator.mediaDevices || typeof navigator.mediaDevices.getUserMedia !== 'function') {
                        const msg = currentLocale.indexOf('ar') === 0
                            ? 'المتصفح لا يدعم التسجيل المباشر من الميكروفون.'
                            : 'This browser does not support direct microphone recording.';
                        showComposerError(msg);
                        showErrorDialog(msg);
                        return;
                    }

                    if (typeof window.lamejs === 'undefined') {
                        const msg = currentLocale.indexOf('ar') === 0
                            ? 'مكتبة تسجيل الصوت لم تُحمَّل. تحقق من اتصالك بالإنترنت وأعد تحميل الصفحة.'
                            : 'Audio encoding library not loaded. Check your internet connection and reload.';
                        showComposerError(msg);
                        showErrorDialog(msg);
                        return;
                    }

                    showComposerError('');
                    navigator.mediaDevices.getUserMedia({ audio: true, video: false })
                        .then(function (stream) {
                            audioStream = stream;
                            mp3Chunks = [];

                            var AC = window.AudioContext || window.webkitAudioContext;
                            if (!AC) {
                                stopAudioTracks();
                                const msg = currentLocale.indexOf('ar') === 0
                                    ? 'المتصفح لا يدعم معالجة الصوت.'
                                    : 'Browser does not support audio processing.';
                                showComposerError(msg);
                                showErrorDialog(msg);
                                return;
                            }

                            try {
                                audioCtx = new AC();
                                audioSourceNode = audioCtx.createMediaStreamSource(stream);
                                audioScriptNode = audioCtx.createScriptProcessor(4096, 1, 1);
                                mp3Encoder = new lamejs.Mp3Encoder(1, audioCtx.sampleRate, 64);

                                audioScriptNode.onaudioprocess = function (e) {
                                    if (!mp3Encoder) return;
                                    var floats = e.inputBuffer.getChannelData(0);
                                    var int16 = new Int16Array(floats.length);
                                    for (var j = 0; j < floats.length; j++) {
                                        var s = Math.max(-1, Math.min(1, floats[j]));
                                        int16[j] = s < 0 ? s * 32768 : s * 32767;
                                    }
                                    var buf = mp3Encoder.encodeBuffer(int16);
                                    if (buf && buf.length > 0) mp3Chunks.push(new Uint8Array(buf));
                                };

                                audioSourceNode.connect(audioScriptNode);
                                audioScriptNode.connect(audioCtx.destination);
                            } catch (err) {
                                stopAudioTracks();
                                if (audioCtx) { try { audioCtx.close(); } catch (e) { } audioCtx = null; }
                                audioScriptNode = null; audioSourceNode = null; mp3Encoder = null; mp3Chunks = [];
                                stopRecordingTimer();
                                const msg = currentLocale.indexOf('ar') === 0
                                    ? 'تعذر بدء تسجيل الصوت من المتصفح.'
                                    : 'Unable to start audio recording.';
                                showComposerError(msg);
                                showErrorDialog(msg);
                                return;
                            }

                            isRecordingAudio = true;
                            startRecordingTimer();
                            updateAudioButtonUi();
                            setBusy(uploadBusy);
                        })
                        .catch(function () {
                            stopRecordingTimer();
                            isRecordingAudio = false;
                            updateAudioButtonUi();
                            const msg = currentLocale.indexOf('ar') === 0
                                ? 'يجب السماح بالوصول إلى الميكروفون لبدء التسجيل.'
                                : 'Microphone permission is required to start recording.';
                            showComposerError(msg);
                            showErrorDialog(msg);
                        });
                }

                updateAudioButtonUi();
                setBusy(false);

                window.addEventListener('beforeunload', function () {
                    cancelAudioRecording();
                });

                if (cancelRecordBtn) {
                    cancelRecordBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        cancelAudioRecording();
                    });
                }

                if (attachBtn && fileInput) {
                    attachBtn.addEventListener('click', function () {
                        fileInput.value = '';
                        fileInput.removeAttribute('accept');
                        fileInput.click();
                    });
                    fileInput.addEventListener('change', function () {
                        const file = fileInput.files && fileInput.files[0] ? fileInput.files[0] : null;
                        if (!file) return;
                        const caption = input ? String(input.value || '').trim() : '';
                        const optimisticMessage = buildOptimisticMediaMessage(file, caption, null);
                        showComposerError('');
                        setBusy(true);
                        upsertOptimisticMessage(optimisticMessage);
                        sendMediaAjax(file, caption, null)
                            .done(function () {
                                upsertOptimisticMessage($.extend({}, optimisticMessage, {
                                    message_status: 'sending',
                                }));
                                if (input) input.value = '';
                                clearReplyToMessage();
                                markActiveConversationOnline();
                                tick();
                            })
                            .fail(function (xhr) {
                                removeOptimisticMessage(optimisticMessage.id);
                                const msg = getAjaxErrorMessage(xhr);
                                showComposerError(msg);
                                showErrorDialog(msg);
                            })
                            .always(function () {
                                setBusy(false);
                                focusComposerIfDesktop(input);
                            });
                    });
                }

                if (audioBtn) {
                    audioBtn.addEventListener('click', function () {
                        if (uploadBusy) return;
                        if (isRecordingAudio) {
                            stopAudioRecording();
                            return;
                        }
                        startAudioRecording();
                    });
                }
            }

            function bindComposerSubmit() {
                const form = document.querySelector('form.wb-composer-form');
                const input = document.getElementById('wb-composer-input');
                if (!form || !input) return;
                const sendBtn = form.querySelector('.wb-send-btn') || form.querySelector('button[type="submit"]');
                var composerSending = false;
                input.addEventListener('input', function () {
                    showComposerError('');
                });

                function submitComposer() {
                    const text = String(input.value || '').trim();
                    if (!text || composerSending) return;
                    showComposerError('');
                    // Use a flag instead of disabled so the keyboard stays open on mobile.
                    composerSending = true;
                    sendMessageAjax(text)
                        .done(function () {
                            input.value = '';
                            clearReplyToMessage();
                            markActiveConversationOnline();
                            tick();
                        })
                        .fail(function (xhr) {
                            const msg = getAjaxErrorMessage(xhr);
                            showComposerError(msg);
                            showErrorDialog(msg);
                        })
                        .always(function () {
                            composerSending = false;
                            focusComposerIfDesktop(input);
                            // Re-pin messages after keyboard animation settles.
                            var msgBox = document.querySelector('.wb-messages');
                            if (msgBox) {
                                setTimeout(function () { msgBox.scrollTop = msgBox.scrollHeight; }, 350);
                            }
                        });
                }

                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    submitComposer();
                });

                if (sendBtn) {
                    // Keep the on-screen keyboard open when tapping send on mobile.
                    // Desktop: preventing the mousedown default stops the button from
                    // stealing focus from the input, without cancelling the click, so the
                    // native form submit still runs.
                    sendBtn.addEventListener('mousedown', function (e) {
                        if (document.activeElement === input) e.preventDefault();
                    });
                    // Mobile: preventing the touchstart default keeps the input focused
                    // (keyboard stays up) but also cancels the synthesized click, so we
                    // fire the send explicitly on touchend. The composerSending flag makes
                    // any duplicate trigger harmless.
                    sendBtn.addEventListener('touchstart', function (e) {
                        if (document.activeElement === input) e.preventDefault();
                    }, { passive: false });
                    sendBtn.addEventListener('touchend', function (e) {
                        if (document.activeElement === input) {
                            e.preventDefault();
                            submitComposer();
                        }
                    }, { passive: false });
                }
            }

            function bindQuickReplies() {
                const btn = document.getElementById('wb-qr-btn');
                const closeBtn = document.getElementById('wb-qr-close');
                const panel = document.getElementById('wb-qr-panel');
                const list = document.getElementById('wb-qr-list');
                const search = document.getElementById('wb-qr-search');
                const input = document.getElementById('wb-composer-input');
                if (btn) btn.addEventListener('click', openQuickRepliesPanel);
                if (closeBtn) closeBtn.addEventListener('click', closeQuickRepliesPanel);
                if (panel) {
                    panel.addEventListener('click', function (e) {
                        const item = e.target && e.target.closest ? e.target.closest('.wb-qr-item') : null;
                        if (!item) return;
                        const id = Number(item.getAttribute('data-qr-id'));
                        const qr = (quickRepliesCache || []).find(function (x) { return Number(x.id) === id; });
                        if (!qr) return;
                        const body = qr && qr.body ? String(qr.body) : '';
                        if (!body) return;
                        closeQuickRepliesPanel();
                        showComposerError('');
                        sendMessageAjax(body)
                            .done(function () {
                                clearReplyToMessage();
                                markActiveConversationOnline();
                                tick();
                            })
                            .fail(function (xhr) {
                                const msg = getAjaxErrorMessage(xhr);
                                showComposerError(msg);
                                showErrorDialog(msg);
                            })
                            .always(function () {
                                focusComposerIfDesktop(input);
                            });
                    });
                }
                if (search) {
                    search.addEventListener('input', function () {
                        renderQuickRepliesList(quickRepliesCache, search.value);
                    });
                }
                if (input) {
                    input.addEventListener('input', function () {
                        const v = String(input.value || '');
                        const idx = v.lastIndexOf('/');
                        if (idx === -1) return;
                        const before = idx > 0 ? v[idx - 1] : ' ';
                        if (before && !/\s/.test(before)) return;
                        const q = v.slice(idx + 1);
                        if (q.indexOf(' ') !== -1) return;
                        openQuickRepliesPanel();
                        if (search) {
                            search.value = q;
                            renderQuickRepliesList(quickRepliesCache, q);
                        }
                    });
                }
                document.addEventListener('click', function (e) {
                    if (!panel || panel.style.display === 'none') return;
                    const inside = e.target && e.target.closest ? e.target.closest('#wb-qr-panel, #wb-qr-btn') : null;
                    if (!inside) closeQuickRepliesPanel();
                });
            }

            function highlightMessageById(messageId) {
                const box = document.querySelector('.wb-messages');
                if (!box || !messageId) return false;
                const item = box.querySelector('[data-message-id="' + String(messageId) + '"]');
                if (!item) return false;
                box.scrollTop = Math.max(0, item.offsetTop - Math.round(box.clientHeight / 3));
                item.classList.add('is-highlighted');
                setTimeout(function () {
                    item.classList.remove('is-highlighted');
                }, 2200);
                return true;
            }

            function showInfoDialog(msg) {
                const text = String(msg || '').trim();
                if (!text) return;
                if (typeof Swal !== 'undefined' && Swal && typeof Swal.fire === 'function') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: text,
                        confirmButtonText: 'OK',
                    });
                    return;
                }
                alert(text);
            }

            function setModalOpen(open) {
                const modal = document.getElementById('wb-new-chat-modal');
                if (!modal) return;
                if (open) {
                    modal.classList.add('is-open');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                } else {
                    modal.classList.remove('is-open');
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                }
            }

            function setModalOpenById(id, open) {
                const modal = document.getElementById(id);
                if (!modal) return;
                if (open) {
                    modal.classList.add('is-open');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                } else {
                    modal.classList.remove('is-open');
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                }
            }

            function formatDateTime(value) {
                return formatLocalizedDateTime(value);
            }

            function renderMeta(meta) {
                const statusEl = document.getElementById('wb-status-pill');
                const tagsWrap = document.getElementById('wb-tags-pills');

                if (statusEl) {
                    const status = meta && meta.conversation && meta.conversation.status ? String(meta.conversation.status) : 'open';
                    statusEl.style.display = 'inline-flex';
                    statusEl.classList.remove('is-open', 'is-resolved');
                    if (status === 'resolved') {
                        statusEl.classList.add('is-resolved');
                        statusEl.innerHTML = '<i class="fa fa-check-circle"></i> ' + escapeHtml(t.resolved);
                    } else if (status === 'snoozed') {
                        statusEl.classList.add('is-open');
                        statusEl.innerHTML = '<i class="fa fa-clock-o"></i> ' + escapeHtml(t.snoozed);
                    } else {
                        statusEl.classList.add('is-open');
                        statusEl.innerHTML = '<i class="fa fa-circle"></i> ' + escapeHtml(t.open);
                    }
                }

                if (tagsWrap) {
                    const tags = meta && meta.tags ? meta.tags : [];
                    if (!tags || tags.length === 0) {
                        tagsWrap.style.display = 'none';
                        tagsWrap.innerHTML = '';
                    } else {
                        tagsWrap.style.display = 'inline-flex';
                        tagsWrap.style.gap = '8px';
                        let html = '';
                        tags.forEach(function (t) {
                            const color = t.color ? String(t.color) : '';
                            const style = color ? ' style="background:' + escapeHtml(color) + '22;border-color:' + escapeHtml(color) + '55;color:' + escapeHtml(color) + ';"' : '';
                            html += '<span class="wb-tag-pill"' + style + ' data-tag-id="' + escapeHtml(t.id) + '"><i class="fa fa-tag"></i> ' + escapeHtml(t.name);
                            if (canUpdateTags) {
                                html += ' <button type="button" class="wb-tag-remove" data-tag-id="' + escapeHtml(t.id) + '" title="' + escapeHtml(currentLocale.indexOf('ar') === 0 ? 'إزالة' : 'Remove') + '"><i class="fa fa-times"></i></button>';
                            }
                            html += '</span>';
                        });
                        tagsWrap.innerHTML = html;
                    }
                }
            }

            function renderMessageSearchResults(items, query) {
                const list = document.getElementById('wb-message-search-results');
                if (!list) return;
                const q = query ? String(query).trim() : '';
                if (!q) {
                    list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.searchHint) + '</div>';
                    return;
                }
                if (!items || items.length === 0) {
                    list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.searchNoResults) + '</div>';
                    return;
                }

                let html = '';
                items.forEach(function (msg) {
                    const body = msg && msg.body ? String(msg.body) : '';
                    const type = msg && msg.type ? String(msg.type) : 'text';
                    const when = formatTime(msg && (msg.wa_timestamp || msg.created_at));
                    const direction = msg && msg.direction === 'out'
                        ? (currentLocale.indexOf('ar') === 0 ? 'صادرة' : 'Outgoing')
                        : (currentLocale.indexOf('ar') === 0 ? 'واردة' : 'Incoming');
                    const preview = body || '[' + type + ']';
                    html += '<div class="wb-search-result" data-message-id="' + escapeHtml(msg.id) + '">';
                    html += '<div class="wb-search-result-meta"><span>' + escapeHtml(direction) + '</span><span>' + escapeHtml(when) + '</span></div>';
                    html += '<div class="wb-search-result-body">' + escapeHtml(preview) + '</div>';
                    html += '</div>';
                });
                list.innerHTML = html;
            }

            function searchMessagesInConversation(query) {
                const list = document.getElementById('wb-message-search-results');
                const q = query ? String(query).trim() : '';
                if (!list) return;
                if (!activeConversationId || !messageSearchUrlTemplate) {
                    list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.noResults) + '</div>';
                    return;
                }
                if (!q) {
                    renderMessageSearchResults([], '');
                    return;
                }

                list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.searchLoading) + '</div>';
                $.get(messageSearchUrlTemplate.replace('__ID__', activeConversationId), { q: q, limit: 50 })
                    .done(function (res) {
                        const items = res && res.data && res.data.items ? res.data.items : [];
                        renderMessageSearchResults(items, q);
                    })
                    .fail(function () {
                        list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.searchNoResults) + '</div>';
                    });
            }

            function renderChatSettings(meta) {
                const summary = document.getElementById('wb-chat-settings-summary');
                if (!summary) return;
                if (!meta || !meta.conversation) {
                    summary.innerHTML = '<div class="wb-empty">' + escapeHtml(t.noResults) + '</div>';
                    return;
                }

                const contactNameEl = document.querySelector('.wb-chat-header .wb-contact-name');
                const contactStatusEl = document.querySelector('.wb-chat-header .wb-contact-status');
                const conversation = meta.conversation || {};
                const account = meta.account || null;
                const tags = meta.tags || [];
                const notes = meta.notes || [];
                const conversationStatus = String(conversation.status || 'open');
                const statusText = conversationStatus === 'resolved'
                    ? t.resolved
                    : (conversationStatus === 'snoozed' ? t.snoozed : t.open);
                const tagsText = tags.length
                    ? tags.map(function (tag) { return tag.name; }).join(currentLocale.indexOf('ar') === 0 ? '، ' : ', ')
                    : t.noResults;
                const notesText = notes.length
                    ? notes.slice(0, 3).map(function (note) { return note.body; }).join('\n\n')
                    : t.settingsNotesEmpty;
                let html = '';
                html += '<div class="wb-settings-item"><div class="wb-settings-label">' + escapeHtml(currentLocale.indexOf('ar') === 0 ? 'الاسم' : 'Name') + '</div><div class="wb-settings-value">' + escapeHtml(contactNameEl ? contactNameEl.textContent : (conversation.display_name || conversation.wa_id || '')) + '</div></div>';
                html += '<div class="wb-settings-item"><div class="wb-settings-label">' + escapeHtml(currentLocale.indexOf('ar') === 0 ? 'رقم واتساب' : 'WhatsApp ID') + '</div><div class="wb-settings-value">' + escapeHtml(conversation.wa_id || '') + '</div></div>';
                html += '<div class="wb-settings-item"><div class="wb-settings-label">' + escapeHtml(currentLocale.indexOf('ar') === 0 ? 'الحالة' : 'Status') + '</div><div class="wb-settings-value">' + escapeHtml(statusText) + '</div></div>';
                html += '<div class="wb-settings-item"><div class="wb-settings-label">' + escapeHtml(currentLocale.indexOf('ar') === 0 ? 'الحساب' : 'Account') + '</div><div class="wb-settings-value">' + escapeHtml(account ? account.name : '') + '</div></div>';
                html += '<div class="wb-settings-item"><div class="wb-settings-label">' + escapeHtml(currentLocale.indexOf('ar') === 0 ? 'الوصف المختصر' : 'Subtitle') + '</div><div class="wb-settings-value">' + escapeHtml(contactStatusEl ? contactStatusEl.textContent : '') + '</div></div>';
                html += '<div class="wb-settings-item"><div class="wb-settings-label">' + escapeHtml(currentLocale.indexOf('ar') === 0 ? 'الوسوم' : 'Tags') + '</div><div class="wb-settings-value">' + escapeHtml(tagsText) + '</div></div>';
                html += '<div class="wb-settings-item"><div class="wb-settings-label">' + escapeHtml(currentLocale.indexOf('ar') === 0 ? 'آخر الملاحظات' : 'Recent Notes') + '</div><div class="wb-settings-value" style="white-space:pre-wrap;">' + escapeHtml(notesText) + '</div></div>';
                summary.innerHTML = html;
            }

            function bindHeaderActions() {
                const searchBtn = document.getElementById('wb-message-search-btn');
                const settingsBtn = document.getElementById('wb-chat-settings-btn');
                const searchCloseBtn = document.getElementById('wb-message-search-close');
                const searchBackdrop = document.getElementById('wb-message-search-backdrop');
                const searchInput = document.getElementById('wb-message-search-input');
                const searchResults = document.getElementById('wb-message-search-results');
                const settingsCloseBtn = document.getElementById('wb-chat-settings-close');
                const settingsBackdrop = document.getElementById('wb-chat-settings-backdrop');
                const settingsTagsBtn = document.getElementById('wb-settings-tags-btn');
                const settingsNotesBtn = document.getElementById('wb-settings-notes-btn');
                const settingsResolveBtn = document.getElementById('wb-settings-resolve-btn');

                function closeSearch() {
                    setModalOpenById('wb-message-search-modal', false);
                }

                function openSearch() {
                    if (!activeConversationId) return;
                    setModalOpenById('wb-message-search-modal', true);
                    renderMessageSearchResults([], '');
                    if (searchInput) {
                        searchInput.value = '';
                        searchInput.focus();
                    }
                }

                function closeSettings() {
                    setModalOpenById('wb-chat-settings-modal', false);
                }

                function openSettings() {
                    if (!activeConversationId) return;
                    setModalOpenById('wb-chat-settings-modal', true);
                    renderChatSettings(metaCache);
                    $.when(loadMeta()).always(function () {
                        renderChatSettings(metaCache);
                    });
                }

                if (searchBtn) searchBtn.addEventListener('click', openSearch);
                if (settingsBtn) settingsBtn.addEventListener('click', openSettings);
                if (searchCloseBtn) searchCloseBtn.addEventListener('click', closeSearch);
                if (searchBackdrop) searchBackdrop.addEventListener('click', closeSearch);
                if (settingsCloseBtn) settingsCloseBtn.addEventListener('click', closeSettings);
                if (settingsBackdrop) settingsBackdrop.addEventListener('click', closeSettings);
                if (searchInput) {
                    searchInput.addEventListener('input', function () {
                        if (messageSearchTimer) clearTimeout(messageSearchTimer);
                        messageSearchTimer = setTimeout(function () {
                            searchMessagesInConversation(searchInput.value);
                        }, 250);
                    });
                }
                if (searchResults) {
                    searchResults.addEventListener('click', function (e) {
                        const item = e.target && e.target.closest ? e.target.closest('.wb-search-result') : null;
                        if (!item) return;
                        const messageId = item.getAttribute('data-message-id');
                        if (!messageId) return;
                        const visible = highlightMessageById(messageId);
                        if (visible) {
                            closeSearch();
                            return;
                        }
                        showInfoDialog(t.messageNotVisible);
                    });
                }
                if (settingsTagsBtn) {
                    settingsTagsBtn.addEventListener('click', function () {
                        closeSettings();
                        const btn = document.getElementById('wb-tag-btn');
                        if (btn) btn.click();
                    });
                }
                if (settingsNotesBtn) {
                    settingsNotesBtn.addEventListener('click', function () {
                        closeSettings();
                        const btn = document.getElementById('wb-note-btn');
                        if (btn) btn.click();
                    });
                }
                if (settingsResolveBtn) {
                    settingsResolveBtn.addEventListener('click', function () {
                        closeSettings();
                        const btn = document.getElementById('wb-resolve-btn');
                        if (btn) btn.click();
                    });
                }
            }

            function loadMeta() {
                if (!activeConversationId || !metaUrlTemplate) return $.Deferred().resolve().promise();
                const requestedConversationId = activeConversationId;
                if (metaLoadingConversationId === requestedConversationId) return $.Deferred().resolve().promise();
                metaLoadingConversationId = requestedConversationId;
                const url = metaUrlTemplate.replace('__ID__', requestedConversationId);
                return $.get(url)
                    .done(function (res) {
                        if (activeConversationId !== requestedConversationId) return;
                        if (res && res.data) {
                            metaCache = res.data;
                            updateActiveConversationUi({
                                wa_id: metaCache.conversation ? metaCache.conversation.wa_id : '',
                                display_name: metaCache.conversation ? metaCache.conversation.display_name : '',
                                last_activity: metaCache.conversation ? metaCache.conversation.last_activity : null
                            });
                            renderMeta(metaCache);
                        }
                    })
                    .always(function () {
                        if (metaLoadingConversationId === requestedConversationId) {
                            metaLoadingConversationId = null;
                        }
                    });
            }

            function renderContacts(items, append) {
                const list = document.getElementById('wb-contact-list');
                if (!list) return;

                let html = '';
                if (!items || items.length === 0) {
                    html = '<div class="wb-empty">' + escapeHtml(t.noResults) + '</div>';
                    if (!append) {
                        list.innerHTML = html;
                    }
                    return;
                }

                items.forEach(function (c) {
                    const name = c && c.name ? String(c.name) : (c && c.wa_id ? String(c.wa_id) : '');
                    const phone = c && c.wa_id ? String(c.wa_id) : '';
                    html += '<div class="wb-contact-item" data-wa-id="' + escapeHtml(phone) + '">';
                    html += '<div class="wb-avatar">' + escapeHtml(initials(name)) + '</div>';
                    html += '<div class="wb-contact-main">';
                    html += '<div class="wb-contact-name">' + escapeHtml(name) + '</div>';
                    html += '<div class="wb-contact-phone">' + escapeHtml(phone) + '</div>';
                    html += '</div>';
                    html += '<div style="color: rgba(0,0,0,0.55);"><i class="fa fa-angle-left"></i></div>';
                    html += '</div>';
                });

                if (append) {
                    list.insertAdjacentHTML('beforeend', html);
                } else {
                    list.innerHTML = html;
                }
            }

            function setContactsMoreVisible(visible) {
                const btn = document.getElementById('wb-contact-more');
                if (!btn) return;
                btn.style.display = visible ? 'block' : 'none';
            }

            function loadContactsFirst() {
                const search = document.getElementById('wb-contact-search');
                const list = document.getElementById('wb-contact-list');
                if (!list) return;

                contactsNextUrl = null;
                setContactsMoreVisible(false);
                list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.loading) + '</div>';

                if (!contactsUrl) {
                    list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.contactsApiUnavailable) + '</div>';
                    return;
                }

                const q = search && search.value ? String(search.value).trim() : '';
                contactsLoading = true;
                $.get(contactsUrl, { limit: 30, search: q })
                    .done(function (res) {
                        const items = res && res.data && res.data.items ? res.data.items : [];
                        contactsNextUrl = res && res.data && res.data.pagination ? res.data.pagination.next_page_url : null;
                        renderContacts(items, false);
                        setContactsMoreVisible(!!contactsNextUrl);
                    })
                    .fail(function () {
                        list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.loadContactsError) + '</div>';
                    })
                    .always(function () {
                        contactsLoading = false;
                    });
            }

            function loadContactsMore() {
                const list = document.getElementById('wb-contact-list');
                if (!list) return;
                if (!contactsNextUrl || contactsLoading) return;

                contactsLoading = true;
                $.get(contactsNextUrl)
                    .done(function (res) {
                        const items = res && res.data && res.data.items ? res.data.items : [];
                        contactsNextUrl = res && res.data && res.data.pagination ? res.data.pagination.next_page_url : null;
                        renderContacts(items, true);
                        setContactsMoreVisible(!!contactsNextUrl);
                    })
                    .fail(function () {
                        setContactsMoreVisible(false);
                    })
                    .always(function () {
                        contactsLoading = false;
                    });
            }

            function bindNewChat() {
                const btn = document.getElementById('wb-new-chat-btn');
                const mobileBtns = document.querySelectorAll('[data-wb-new-chat-trigger]');
                const closeBtn = document.getElementById('wb-new-chat-close');
                const backdrop = document.getElementById('wb-new-chat-backdrop');
                const search = document.getElementById('wb-contact-search');
                const list = document.getElementById('wb-contact-list');
                const more = document.getElementById('wb-contact-more');

                function close() {
                    setModalOpen(false);
                }

                function open() {
                    setModalOpen(true);
                    if (search) {
                        search.value = '';
                        search.focus();
                    }
                    loadContactsFirst();
                }

                if (btn) {
                    btn.addEventListener('click', open);
                }
                mobileBtns.forEach(function (mobileBtn) {
                    mobileBtn.addEventListener('click', open);
                });
                if (closeBtn) {
                    closeBtn.addEventListener('click', close);
                }
                if (backdrop) {
                    backdrop.addEventListener('click', close);
                }
                if (more) {
                    more.addEventListener('click', loadContactsMore);
                }
                if (search) {
                    let t = null;
                    search.addEventListener('input', function () {
                        if (t) clearTimeout(t);
                        t = setTimeout(function () {
                            loadContactsFirst();
                        }, 250);
                    });
                }
                if (list) {
                    list.addEventListener('click', function (e) {
                        const item = e.target && e.target.closest ? e.target.closest('.wb-contact-item') : null;
                        if (!item) return;
                        const waId = item.getAttribute('data-wa-id');
                        if (!waId) return;
                        window.location.href = buildChatIndexUrl({ wa_id: waId });
                    });
                }

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        close();
                    }
                });
            }

            function bindActionMenu() {
                const menu = document.getElementById('wb-action-menu');
                const toggle = document.getElementById('wb-action-menu-toggle');
                const panel = document.getElementById('wb-action-menu-panel');
                if (!menu || !toggle || !panel) return;

                function setOpen(open) {
                    menu.classList.toggle('is-open', open);
                    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                }

                toggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    setOpen(!menu.classList.contains('is-open'));
                });

                panel.addEventListener('click', function (e) {
                    if (e.target && e.target.closest && e.target.closest('.wb-qa-btn')) {
                        setOpen(false);
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!menu.classList.contains('is-open')) return;
                    const inside = e.target && e.target.closest ? e.target.closest('#wb-action-menu') : null;
                    if (!inside) setOpen(false);
                });

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        setOpen(false);
                    }
                });
            }

            function renderTagsPicker(items, selectedIds) {
                const list = document.getElementById('wb-tags-list');
                if (!list) return;
                if (!items || items.length === 0) {
                    list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.noTagsAvailable) + '</div>';
                    return;
                }
                const selected = new Set((selectedIds || []).map(function (x) { return Number(x); }));
                let html = '';
                items.forEach(function (t) {
                    const id = Number(t.id);
                    const name = t && t.name ? String(t.name) : '';
                    const color = t && t.color ? String(t.color) : '';
                    const checked = selected.has(id) ? ' checked' : '';
                    const style = color ? ' style="background:' + escapeHtml(color) + '22;border-color:' + escapeHtml(color) + '55;"' : '';
                    html += '<label class="wb-contact-item" style="cursor:pointer;"' + style + '>';
                    html += '<input type="checkbox" class="wb-tag-check" value="' + escapeHtml(id) + '"' + checked + ' style="width:18px;height:18px;">';
                    html += '<div class="wb-contact-main">';
                    html += '<div class="wb-contact-name">' + escapeHtml(name) + '</div>';
                    html += '<div class="wb-contact-phone">' + escapeHtml(color) + '</div>';
                    html += '</div>';
                    html += '</label>';
                });
                list.innerHTML = html;
            }

            function setConversationTags(tagIds) {
                if (!activeConversationId || !setTagsUrlTemplate) return $.Deferred().reject().promise();
                const url = setTagsUrlTemplate.replace('__ID__', activeConversationId);
                const ids = (tagIds || []).map(function (x) { return Number(x); }).filter(function (x) { return !isNaN(x); });
                return $.ajax({
                    url: url,
                    type: 'PUT',
                    data: { tag_ids: ids }
                });
            }

            function loadTags(search) {
                const list = document.getElementById('wb-tags-list');
                if (!list) return;
                if (!tagsUrl) {
                    list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.tagsApiUnavailable) + '</div>';
                    return;
                }
                list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.loading) + '</div>';
                $.get(tagsUrl, { search: search || '' })
                    .done(function (res) {
                        const items = res && res.data && res.data.items ? res.data.items : [];
                        const selectedIds = metaCache && metaCache.tags ? metaCache.tags.map(function (t) { return t.id; }) : [];
                        renderTagsPicker(items, selectedIds);
                    })
                    .fail(function () {
                        list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.loadTagsError) + '</div>';
                    });
            }

            function saveTags() {
                const checks = Array.from(document.querySelectorAll('.wb-tag-check:checked'));
                const ids = checks.map(function (c) { return Number(c.value); }).filter(function (x) { return !isNaN(x); });
                setConversationTags(ids)
                    .done(function () {
                        loadMeta();
                        loadConversations();
                        setModalOpenById('wb-tags-modal', false);
                    })
                    .fail(function () {
                        showInfoDialog(currentLocale.indexOf('ar') === 0 ? 'لا تملك الصلاحية لتعديل وسوم المحادثة.' : 'You do not have permission to update chat tags.');
                    });
            }

            function normalizeHex(val) {
                if (!val) return null;
                let v = String(val).trim();
                if (!v) return null;
                if (v[0] !== '#') v = '#' + v;
                if (/^#[0-9a-fA-F]{3}$/.test(v)) {
                    v = '#' + v[1] + v[1] + v[2] + v[2] + v[3] + v[3];
                }
                if (!/^#[0-9a-fA-F]{6}$/.test(v)) return null;
                return v.toLowerCase();
            }

            function createTag() {
                const nameEl = document.getElementById('wb-new-tag-name');
                const colorEl = document.getElementById('wb-new-tag-color');
                const colorPickerEl = document.getElementById('wb-new-tag-color-picker');
                if (!nameEl || !tagsStoreUrl) return;
                const name = nameEl.value ? String(nameEl.value).trim() : '';
                const color = colorEl && colorEl.value ? String(colorEl.value).trim() : '';
                if (!name) return;
                const normalizedColor = normalizeHex(color);
                $.post(tagsStoreUrl, { name: name, color: normalizedColor || (color || null) })
                    .done(function () {
                        nameEl.value = '';
                        if (colorEl) colorEl.value = '';
                        if (colorPickerEl) colorPickerEl.value = '#6c757d';
                        loadTags(document.getElementById('wb-tags-search') ? document.getElementById('wb-tags-search').value : '');
                    });
            }

            function bindTags() {
                const btn = document.getElementById('wb-tag-btn');
                const closeBtn = document.getElementById('wb-tags-close');
                const backdrop = document.getElementById('wb-tags-backdrop');
                const search = document.getElementById('wb-tags-search');
                const saveBtn = document.getElementById('wb-save-tags-btn');
                const clearBtn = document.getElementById('wb-clear-tags-btn');
                const createBtn = document.getElementById('wb-create-tag-btn');
                const colorPicker = document.getElementById('wb-new-tag-color-picker');
                const colorText = document.getElementById('wb-new-tag-color');

                function close() {
                    setModalOpenById('wb-tags-modal', false);
                }

                function open() {
                    if (!activeConversationId) return;
                    setModalOpenById('wb-tags-modal', true);
                    if (search) {
                        search.value = '';
                        search.focus();
                    }
                    if (colorPicker && colorText) {
                        const normalized = normalizeHex(colorText.value);
                        if (normalized) colorPicker.value = normalized;
                    }
                    $.when(loadMeta()).always(function () {
                        loadTags('');
                    });
                }

                if (btn) {
                    btn.addEventListener('click', open);
                    if (!activeConversationId) btn.setAttribute('disabled', 'disabled');
                }
                if (closeBtn) closeBtn.addEventListener('click', close);
                if (backdrop) backdrop.addEventListener('click', close);
                if (saveBtn) saveBtn.addEventListener('click', saveTags);
                if (clearBtn) {
                    clearBtn.addEventListener('click', function () {
                        setConversationTags([])
                            .done(function () {
                                loadMeta();
                                loadConversations();
                                setModalOpenById('wb-tags-modal', false);
                            })
                            .fail(function () {
                                showInfoDialog(currentLocale.indexOf('ar') === 0 ? 'لا تملك الصلاحية لإزالة الوسوم.' : 'You do not have permission to remove tags.');
                            });
                    });
                }
                if (createBtn) createBtn.addEventListener('click', createTag);
                if (colorPicker && colorText) {
                    colorPicker.addEventListener('input', function () {
                        colorText.value = colorPicker.value || '';
                    });
                    colorText.addEventListener('input', function () {
                        const normalized = normalizeHex(colorText.value);
                        if (normalized) colorPicker.value = normalized;
                    });
                }
                if (search) {
                    let t = null;
                    search.addEventListener('input', function () {
                        if (t) clearTimeout(t);
                        t = setTimeout(function () {
                            loadTags(search.value);
                        }, 250);
                    });
                }
            }

            function bindTagPills() {
                if (!canUpdateTags) return;
                const tagsWrap = document.getElementById('wb-tags-pills');
                if (!tagsWrap) return;
                tagsWrap.addEventListener('click', function (e) {
                    const btn = e.target && e.target.closest ? e.target.closest('.wb-tag-remove') : null;
                    if (!btn) return;
                    e.preventDefault();
                    e.stopPropagation();
                    const id = btn.getAttribute('data-tag-id');
                    const tagId = id ? Number(id) : NaN;
                    if (isNaN(tagId) || !metaCache || !metaCache.tags) return;
                    const remaining = metaCache.tags
                        .map(function (t) { return Number(t.id); })
                        .filter(function (x) { return !isNaN(x) && x !== tagId; });
                    setConversationTags(remaining)
                        .done(function () {
                            loadMeta();
                            loadConversations();
                        })
                        .fail(function () {
                            showInfoDialog(currentLocale.indexOf('ar') === 0 ? 'تعذر إزالة الوسم.' : 'Failed to remove tag.');
                        });
                });
            }

            function renderNotesList(notes) {
                const list = document.getElementById('wb-notes-list');
                if (!list) return;
                if (!notes || notes.length === 0) {
                    list.innerHTML = '<div class="wb-empty">' + escapeHtml(t.noNotes) + '</div>';
                    return;
                }
                let html = '';
                notes.forEach(function (n) {
                    const adminName = n && n.user && n.user.name ? String(n.user.name) : t.system;
                    const when = formatDateTime(n.created_at);
                    html += '<div class="wb-note-item">';
                    html += '<div class="wb-note-meta"><span>' + escapeHtml(adminName) + '</span><span>' + escapeHtml(when) + '</span></div>';
                    html += '<div style="white-space:pre-wrap;color:rgba(0,0,0,0.8);">' + escapeHtml(n.body || '') + '</div>';
                    html += '</div>';
                });
                list.innerHTML = html;
            }

            function addNote() {
                const bodyEl = document.getElementById('wb-note-body');
                if (!bodyEl || !activeConversationId || !addNoteUrlTemplate) return;
                const body = bodyEl.value ? String(bodyEl.value).trim() : '';
                if (!body) return;
                const url = addNoteUrlTemplate.replace('__ID__', activeConversationId);
                $.post(url, { body: body })
                    .done(function () {
                        bodyEl.value = '';
                        loadMeta().done(function () {
                            renderNotesList(metaCache && metaCache.notes ? metaCache.notes : []);
                        });
                    });
            }

            function bindNotes() {
                const btn = document.getElementById('wb-note-btn');
                const closeBtn = document.getElementById('wb-notes-close');
                const backdrop = document.getElementById('wb-notes-backdrop');
                const addBtn = document.getElementById('wb-add-note-btn');

                function close() {
                    setModalOpenById('wb-notes-modal', false);
                }

                function open() {
                    if (!activeConversationId) return;
                    setModalOpenById('wb-notes-modal', true);
                    loadMeta().done(function () {
                        renderNotesList(metaCache && metaCache.notes ? metaCache.notes : []);
                    });
                }

                if (btn) {
                    btn.addEventListener('click', open);
                    if (!activeConversationId) btn.setAttribute('disabled', 'disabled');
                }
                if (closeBtn) closeBtn.addEventListener('click', close);
                if (backdrop) backdrop.addEventListener('click', close);
                if (addBtn) addBtn.addEventListener('click', addNote);
            }

            function resolveToggle() {
                if (!activeConversationId || !resolveUrlTemplate) return;
                const url = resolveUrlTemplate.replace('__ID__', activeConversationId);
                $.ajax({ url: url, type: 'PUT', data: {} })
                    .done(function () {
                        loadMeta();
                        loadConversations();
                    });
            }

            function bindResolve() {
                const btn = document.getElementById('wb-resolve-btn');
                if (!btn) return;
                btn.addEventListener('click', resolveToggle);
                if (!activeConversationId) btn.setAttribute('disabled', 'disabled');
            }

            function bindChatResize() {
                const inbox = document.querySelector('.wb-inbox');
                const button = document.getElementById('wb-chat-resize-btn');
                if (!inbox || !button) return;

                const expandLabel = currentLocale.indexOf('ar') === 0 ? 'تكبير المحادثة' : 'Expand chat';
                const restoreLabel = currentLocale.indexOf('ar') === 0 ? 'العودة للحجم الطبيعي' : 'Restore chat size';

                function setExpanded(expanded) {
                    inbox.classList.toggle('is-expanded', expanded);
                    button.classList.toggle('is-expanded', expanded);
                    document.body.classList.toggle('wb-chat-expanded', expanded);
                    button.setAttribute('aria-pressed', expanded ? 'true' : 'false');
                    button.setAttribute('aria-label', expanded ? restoreLabel : expandLabel);
                    button.setAttribute('title', expanded ? restoreLabel : expandLabel);
                }

                button.addEventListener('click', function () {
                    setExpanded(!inbox.classList.contains('is-expanded'));
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape' && inbox.classList.contains('is-expanded')) {
                        setExpanded(false);
                        button.focus();
                    }
                });

                window.addEventListener('pagehide', function () {
                    document.body.classList.remove('wb-chat-expanded');
                });
            }

            setTimeout(function () {
                bindSearch();
                bindConversationSelection();
                bindConversationsPagination();
                bindMessagesPagination();
                bindConversationTabs();
                bindTypingIndicator();
                bindComposerSubmit();
                bindReplyBar();
                bindComposerTools();
                bindAttachments();
                bindQuickReplies();
                bindHeaderActions();
                bindNewChat();
                bindActionMenu();
                bindTags();
                bindNotes();
                bindResolve();
                bindChatResize();
                bindTagPills();
                bindGlobalAudioPlayer();
                bindMessageActions();

                // Prevent the mobile keyboard from popping up and covering the chat on
                // load. `pageshow` also fires on a back/forward-cache (bfcache) restore —
                // this setTimeout does not run again then, but the listener persists and
                // re-applies the guard so reopening the page keeps the keyboard closed.
                blurComposerOnMobile();
                window.addEventListener('pageshow', function () {
                    blurComposerOnMobile();
                });

                tick();
                setInterval(tick, 3000);
            }, 500);
        })();
    </script>
@endsection
