@extends('crm.layout')

@section('page-title', $pageTitle)

@section('style')
    <style>
        .wa-rp {
            --wa-rp-brand: #4a5cff;
            --wa-rp-ink: #0b0c10;
            --wa-rp-muted: #6b7080;
            --wa-rp-border: #e7e8ee;
            --wa-rp-card: #fff;
            --wa-rp-chip: #f1f2f5;
            --wa-rp-track: #eef0f4;
            color: var(--wa-rp-ink);
        }

        [data-pc-theme="dark"] .wa-rp {
            --wa-rp-ink: #f3f4f7;
            --wa-rp-muted: #9a9fb0;
            --wa-rp-border: rgba(255, 255, 255, 0.08);
            --wa-rp-card: #1b1d26;
            --wa-rp-chip: rgba(255, 255, 255, 0.07);
            --wa-rp-track: rgba(255, 255, 255, 0.08);
        }

        .wa-rp-head {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .wa-rp-title {
            margin: 0 0 4px;
            font-size: 1.85rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--wa-rp-ink);
        }

        .wa-rp-subtitle {
            margin: 0;
            color: var(--wa-rp-muted);
            font-size: 0.95rem;
        }

        .wa-rp-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .wa-rp-periods {
            display: inline-flex;
            padding: 4px;
            gap: 2px;
            border: 1px solid var(--wa-rp-border);
            border-radius: 14px;
            background: var(--wa-rp-card);
        }

        .wa-days-btn {
            border: 0;
            background: transparent;
            color: var(--wa-rp-muted);
            font-size: 0.8rem;
            font-weight: 700;
            padding: 8px 14px;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.15s ease, color 0.15s ease;
        }

        .wa-days-btn:hover {
            color: var(--wa-rp-ink);
        }

        .wa-days-btn.is-active {
            pointer-events: none;
            background: var(--wa-rp-chip);
            color: var(--wa-rp-ink);
        }

        .wa-days-btn:disabled {
            opacity: 0.6;
        }

        .wa-rp-export {
            border: 0;
            background: var(--wa-rp-ink);
            color: var(--wa-rp-card);
            font-size: 0.8rem;
            font-weight: 700;
            padding: 12px 20px;
            border-radius: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.15s ease;
        }

        .wa-rp-export:hover {
            opacity: 0.88;
        }

        .wa-rp-card {
            background: var(--wa-rp-card);
            border: 1px solid var(--wa-rp-border);
            border-radius: 20px;
            height: 100%;
        }

        .wa-stat-card {
            padding: 20px 18px;
        }

        .wa-stat-label {
            color: var(--wa-rp-muted);
            font-size: 0.9rem;
            margin-bottom: 6px;
        }

        .wa-stat-value {
            font-size: 2.25rem;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.02em;
            color: var(--wa-rp-ink);
            margin-bottom: 10px;
        }

        .wa-rp-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 9px;
            border-radius: 8px;
            background: var(--wa-rp-chip);
            color: var(--wa-rp-ink);
            font-size: 0.72rem;
            font-weight: 600;
        }

        .wa-rp-panel {
            padding: 20px 18px;
            display: flex;
            flex-direction: column;
        }

        .wa-rp-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 14px;
        }

        .wa-rp-panel-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 800;
            color: var(--wa-rp-ink);
        }

        .wa-rp-legend {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(74, 92, 255, 0.1);
            color: var(--wa-rp-brand);
            font-size: 0.72rem;
            font-weight: 700;
        }

        .wa-trend {
            flex: 1 1 auto;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 14px;
            min-height: 320px;
            padding-top: 10px;
        }

        .wa-trend-col {
            flex: 1 1 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            height: 320px;
            min-width: 0;
        }

        .wa-trend-bar {
            width: 100%;
            max-width: 44px;
            border-radius: 10px;
            background: var(--wa-rp-brand);
            transition: height 0.4s ease, opacity 0.15s ease;
        }

        .wa-trend-col:hover .wa-trend-bar {
            opacity: 0.85;
        }

        .wa-trend-value {
            font-size: 0.72rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--wa-rp-muted);
        }

        .wa-trend-label {
            margin-top: 10px;
            font-size: 0.8rem;
            color: var(--wa-rp-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .wa-source-row {
            padding: 12px 0;
            border-bottom: 1px solid var(--wa-rp-border);
        }

        .wa-source-row:first-child {
            padding-top: 0;
        }

        .wa-source-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 8px;
            font-size: 0.92rem;
            color: var(--wa-rp-ink);
        }

        .wa-source-count {
            color: var(--wa-rp-muted);
            font-size: 0.85rem;
        }

        .wa-source-track {
            height: 6px;
            border-radius: 999px;
            background: var(--wa-rp-track);
            overflow: hidden;
        }

        .wa-source-fill {
            height: 100%;
            border-radius: 999px;
            background: var(--wa-rp-brand);
            transition: width 0.4s ease;
        }

        .wa-rp-empty {
            color: var(--wa-rp-muted);
            text-align: center;
            padding: 32px 0;
            width: 100%;
        }

        .wa-trend .wa-rp-empty {
            align-self: center;
        }

        @media (max-width: 575.98px) {
            .wa-rp-title {
                font-size: 1.5rem;
            }

            .wa-rp-actions {
                width: 100%;
                justify-content: space-between;
            }

            .wa-trend,
            .wa-trend-col {
                min-height: 220px;
                height: 220px;
            }

            .wa-trend {
                gap: 6px;
            }
        }
    </style>
@endsection

@section('content')
    <div id="whatsapp-analytics-root" class="wa-rp"
         data-url="{{ route('crm.whatsapp_analytics') }}"
         data-days="{{ $days }}"
         data-t-no-data="{{ __('whatsapp_no_data') }}"
         data-t-error="{{ __('auth.an error occurred') }}">

        <div class="wa-rp-head">
            <div>
                <h1 class="wa-rp-title">{{ __('whatsapp_analytics') }}</h1>
                <p class="wa-rp-subtitle">{{ __('whatsapp_analytics_hint') }}</p>
            </div>
            <div class="wa-rp-actions">
                <div class="wa-rp-periods" role="group" aria-label="{{ __('whatsapp_analytics') }}">
                    @foreach ([7, 30, 90] as $option)
                        <button type="button"
                                class="wa-days-btn {{ $days === $option ? 'is-active' : '' }}"
                                data-days="{{ $option }}"
                                data-label="{{ __('whatsapp_last_' . $option . '_days') }}">
                            {{ __('whatsapp_last_' . $option . '_days') }}
                        </button>
                    @endforeach
                </div>
                <button type="button" class="wa-rp-export" id="wa-export-btn">
                    <i class="fal fa-arrow-down-to-line" aria-hidden="true"></i>{{ __('whatsapp_export') }}
                </button>
            </div>
        </div>

        <div class="alert alert-danger d-none" id="wa-feedback" role="alert" aria-live="polite"></div>

        <div class="row g-3">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="wa-rp-card wa-stat-card">
                    <div class="wa-stat-label">{{ __('whatsapp_total_messages') }}</div>
                    <div class="wa-stat-value" id="wa-total-messages">{{ number_format($totalMessages) }}</div>
                    <span class="wa-rp-chip">
                        <span id="wa-inbound-messages">{{ number_format($inboundMessages) }}</span> {{ __('whatsapp_messages_in') }}
                        ·
                        <span id="wa-outbound-messages">{{ number_format($outboundMessages) }}</span> {{ __('whatsapp_messages_out') }}
                    </span>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="wa-rp-card wa-stat-card">
                    <div class="wa-stat-label">{{ __('whatsapp_total_conversations') }}</div>
                    <div class="wa-stat-value" id="wa-total-conversations">{{ number_format($totalConversations) }}</div>
                    <span class="wa-rp-chip">
                        <span id="wa-new-conversations">{{ number_format($newConversations) }}</span> {{ __('whatsapp_new_conversations') }}
                    </span>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="wa-rp-card wa-stat-card">
                    <div class="wa-stat-label">{{ __('whatsapp_response_rate') }}</div>
                    <div class="wa-stat-value" id="wa-response-rate">{{ $responseRate === null ? '—' : $responseRate . '%' }}</div>
                    <span class="wa-rp-chip wa-period-chip">{{ __('whatsapp_last_' . $days . '_days') }}</span>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="wa-rp-card wa-stat-card">
                    <div class="wa-stat-label">{{ __('whatsapp_avg_response') }}</div>
                    <div class="wa-stat-value" id="wa-avg-response">{{ $avgResponseHuman ?? '—' }}</div>
                    <span class="wa-rp-chip wa-period-chip">{{ __('whatsapp_last_' . $days . '_days') }}</span>
                </div>
            </div>

            <div class="col-12 col-xl-8">
                <div class="wa-rp-card wa-rp-panel">
                    <div class="wa-rp-panel-head">
                        <h2 class="wa-rp-panel-title">{{ __('whatsapp_conversations_over_time') }}</h2>
                        <span class="wa-rp-legend">{{ __('whatsapp_total_conversations') }}</span>
                    </div>
                    <div class="wa-trend" id="wa-trend"></div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="wa-rp-card wa-rp-panel">
                    <div class="wa-rp-panel-head">
                        <h2 class="wa-rp-panel-title">{{ __('whatsapp_conversation_sources') }}</h2>
                    </div>
                    <div id="wa-sources"></div>
                </div>
            </div>
        </div>
    </div>
    @include('crm.partials.help-modal', [
        'title' => __('crm_help_analytics_title'),
        'description' => __('crm_help_analytics_desc'),
    ])
@endsection

@section('js')
    <script>
        (function () {
            const root = document.getElementById('whatsapp-analytics-root');
            if (!root) {
                return;
            }

            const url = root.dataset.url || '';
            const tNoData = root.dataset.tNoData || '';
            const tError = root.dataset.tError || '';
            const feedback = document.getElementById('wa-feedback');
            const trendEl = document.getElementById('wa-trend');
            const sourcesEl = document.getElementById('wa-sources');
            const sourceLabels = {
                organic: @json(__('whatsapp_source_organic')),
                broadcast: @json(__('whatsapp_source_broadcast')),
                ads: @json(__('whatsapp_source_ads')),
                other: @json(__('whatsapp_source_other')),
            };

            function escapeHtml(value) {
                return String(value === null || value === undefined ? '' : value)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function formatNumber(value) {
                return new Intl.NumberFormat(document.documentElement.lang || undefined).format(value || 0);
            }

            function setText(id, value) {
                const el = document.getElementById(id);
                if (el) {
                    el.textContent = value;
                }
            }

            function showError(message) {
                if (!feedback) {
                    return;
                }
                feedback.textContent = message || tError;
                feedback.classList.remove('d-none');
            }

            function clearError() {
                if (!feedback) {
                    return;
                }
                feedback.textContent = '';
                feedback.classList.add('d-none');
            }

            function renderTrend(trend) {
                const labels = (trend && trend.labels) || [];
                const counts = (trend && trend.counts) || [];
                const max = Math.max.apply(null, counts.concat([0]));

                if (!counts.length || max <= 0) {
                    trendEl.innerHTML = '<div class="wa-rp-empty">' + escapeHtml(tNoData) + '</div>';
                    return;
                }

                trendEl.innerHTML = counts.map(function (count, index) {
                    const height = count > 0 ? Math.max(4, Math.round((count / max) * 100)) : 0;
                    return '<div class="wa-trend-col">' +
                        '<span class="wa-trend-value">' + escapeHtml(formatNumber(count)) + '</span>' +
                        '<div class="wa-trend-bar" style="height:' + height + '%"></div>' +
                        '<span class="wa-trend-label">' + escapeHtml(labels[index] || '') + '</span>' +
                        '</div>';
                }).join('');
            }

            function renderSources(sources, sourcesPct) {
                const keys = ['organic', 'broadcast', 'ads', 'other'];
                const hasData = keys.some(function (key) {
                    return (sources && sources[key]) > 0;
                });

                if (!hasData) {
                    sourcesEl.innerHTML = '<div class="wa-rp-empty">' + escapeHtml(tNoData) + '</div>';
                    return;
                }

                sourcesEl.innerHTML = keys.map(function (key) {
                    const count = (sources && sources[key]) || 0;
                    const pct = (sourcesPct && sourcesPct[key]) || 0;
                    return '<div class="wa-source-row">' +
                        '<div class="wa-source-head">' +
                        '<span>' + escapeHtml(sourceLabels[key] || key) + '</span>' +
                        '<span class="wa-source-count">' + escapeHtml(formatNumber(count)) + ' · ' + pct + '%</span>' +
                        '</div>' +
                        '<div class="wa-source-track" role="progressbar" aria-valuenow="' + pct + '" aria-valuemin="0" aria-valuemax="100">' +
                        '<div class="wa-source-fill" style="width:' + pct + '%"></div>' +
                        '</div>' +
                        '</div>';
                }).join('');
            }

            let lastData = null;

            function render(data) {
                lastData = data;
                setText('wa-total-messages', formatNumber(data.totalMessages));
                setText('wa-inbound-messages', formatNumber(data.inboundMessages));
                setText('wa-outbound-messages', formatNumber(data.outboundMessages));
                setText('wa-total-conversations', formatNumber(data.totalConversations));
                setText('wa-new-conversations', formatNumber(data.newConversations));
                setText('wa-response-rate', data.responseRate === null ? '—' : data.responseRate + '%');
                setText('wa-avg-response', data.avgResponseHuman || '—');

                renderTrend(data.trend);
                renderSources(data.sources, data.sourcesPct);
            }

            function setActiveDays(days) {
                root.querySelectorAll('.wa-days-btn').forEach(function (button) {
                    const isActive = Number(button.dataset.days) === Number(days);
                    button.classList.toggle('is-active', isActive);
                    if (isActive) {
                        root.querySelectorAll('.wa-period-chip').forEach(function (chip) {
                            chip.textContent = button.dataset.label || '';
                        });
                    }
                });
                root.dataset.days = String(days);
            }

            function load(days) {
                clearError();
                root.querySelectorAll('.wa-days-btn').forEach(function (button) {
                    button.disabled = true;
                });

                fetch(url + '?days=' + encodeURIComponent(days), {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                })
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error('request failed');
                        }
                        return response.json();
                    })
                    .then(function (payload) {
                        render(payload.data || {});
                        setActiveDays(days);

                        if (window.history && window.history.replaceState) {
                            window.history.replaceState(null, '', url + '?days=' + encodeURIComponent(days));
                        }
                    })
                    .catch(function () {
                        showError(tError);
                    })
                    .finally(function () {
                        root.querySelectorAll('.wa-days-btn').forEach(function (button) {
                            button.disabled = false;
                        });
                    });
            }

            root.querySelectorAll('.wa-days-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    if (button.classList.contains('is-active')) {
                        return;
                    }
                    load(button.dataset.days);
                });
            });

            function csvCell(value) {
                return '"' + String(value === null || value === undefined ? '' : value).replace(/"/g, '""') + '"';
            }

            function exportCsv() {
                const data = lastData || {};
                const rows = [
                    [@json(__('whatsapp_total_messages')), data.totalMessages],
                    [@json(__('whatsapp_messages_in')), data.inboundMessages],
                    [@json(__('whatsapp_messages_out')), data.outboundMessages],
                    [@json(__('whatsapp_total_conversations')), data.totalConversations],
                    [@json(__('whatsapp_new_conversations')), data.newConversations],
                    [@json(__('whatsapp_response_rate')), data.responseRate === null ? '' : data.responseRate + '%'],
                    [@json(__('whatsapp_avg_response')), data.avgResponseHuman || ''],
                    [],
                    [@json(__('whatsapp_conversations_over_time'))],
                ];
                const trend = data.trend || {};
                (trend.labels || []).forEach(function (label, index) {
                    rows.push([label, (trend.counts || [])[index] || 0]);
                });
                rows.push([], [@json(__('whatsapp_conversation_sources'))]);
                ['organic', 'broadcast', 'ads', 'other'].forEach(function (key) {
                    rows.push([sourceLabels[key] || key, (data.sources || {})[key] || 0, ((data.sourcesPct || {})[key] || 0) + '%']);
                });

                const csv = '\ufeff' + rows.map(function (row) {
                    return row.map(csvCell).join(',');
                }).join('\r\n');
                const link = document.createElement('a');
                link.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8' }));
                link.download = 'whatsapp-report-' + (root.dataset.days || '') + 'd.csv';
                document.body.appendChild(link);
                link.click();
                link.remove();
                setTimeout(function () {
                    URL.revokeObjectURL(link.href);
                }, 1000);
            }

            const exportBtn = document.getElementById('wa-export-btn');
            if (exportBtn) {
                exportBtn.addEventListener('click', exportCsv);
            }

            render({
                totalMessages: @json($totalMessages),
                inboundMessages: @json($inboundMessages),
                outboundMessages: @json($outboundMessages),
                totalConversations: @json($totalConversations),
                newConversations: @json($newConversations),
                responseRate: @json($responseRate),
                avgResponseHuman: @json($avgResponseHuman),
                trend: @json($trend),
                sources: @json($sources),
                sourcesPct: @json($sourcesPct),
            });
        })();
    </script>
@endsection
