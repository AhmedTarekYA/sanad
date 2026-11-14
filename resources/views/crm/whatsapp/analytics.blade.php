@extends('crm.layout')

@section('page-title', $pageTitle)

@section('style')
    <style>
        .wa-stat-card .wa-stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            background: rgba(var(--bs-primary-rgb), 0.1);
            color: var(--bs-primary);
        }

        .wa-stat-card .wa-stat-value {
            font-size: 1.7rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .wa-stat-card .wa-stat-label {
            color: var(--bs-secondary-color);
            font-size: 0.85rem;
        }

        .wa-trend {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 12px;
            min-height: 220px;
            padding-top: 10px;
        }

        .wa-trend-col {
            flex: 1 1 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            height: 220px;
            min-width: 0;
        }

        .wa-trend-bar {
            width: 100%;
            max-width: 46px;
            border-radius: 8px 8px 0 0;
            background: linear-gradient(180deg, var(--bs-primary), rgba(var(--bs-primary-rgb), 0.55));
            transition: height 0.4s ease;
            position: relative;
        }

        .wa-trend-value {
            font-size: 0.72rem;
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--bs-body-color);
        }

        .wa-trend-label {
            margin-top: 8px;
            font-size: 0.72rem;
            color: var(--bs-secondary-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .wa-source-row + .wa-source-row {
            margin-top: 16px;
        }

        .wa-source-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 6px;
            font-size: 0.85rem;
        }

        .wa-source-count {
            font-weight: 600;
        }

        .wa-days-btn.is-active {
            pointer-events: none;
        }
    </style>
@endsection

@section('content')
    <div id="whatsapp-analytics-root"
         data-url="{{ route('crm.whatsapp_analytics') }}"
         data-t-no-data="{{ __('whatsapp_no_data') }}"
         data-t-error="{{ __('auth.an error occurred') }}">

        <div class="row g-3">
            <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <h5 class="mb-1">{{ __('whatsapp_analytics') }}</h5>
                    <small class="text-muted">{{ __('whatsapp_analytics_hint') }}</small>
                </div>
                <div class="btn-group" role="group" aria-label="{{ __('whatsapp_analytics') }}">
                    @foreach ([7, 30, 90] as $option)
                        <button type="button"
                                class="btn btn-sm {{ $days === $option ? 'btn-primary is-active' : 'btn-outline-primary' }} wa-days-btn"
                                data-days="{{ $option }}">
                            {{ __('whatsapp_last_' . $option . '_days') }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="col-12">
                <div class="alert alert-danger d-none" id="wa-feedback" role="alert" aria-live="polite"></div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 wa-stat-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="wa-stat-icon"><i class="ti ti-message" aria-hidden="true"></i></span>
                        <div class="min-w-0">
                            <div class="wa-stat-value" id="wa-total-messages">{{ number_format($totalMessages) }}</div>
                            <div class="wa-stat-label">{{ __('whatsapp_total_messages') }}</div>
                            <div class="small text-muted mt-1">
                                <span id="wa-inbound-messages">{{ number_format($inboundMessages) }}</span> {{ __('whatsapp_messages_in') }}
                                ·
                                <span id="wa-outbound-messages">{{ number_format($outboundMessages) }}</span> {{ __('whatsapp_messages_out') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 wa-stat-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="wa-stat-icon"><i class="ti ti-messages" aria-hidden="true"></i></span>
                        <div class="min-w-0">
                            <div class="wa-stat-value" id="wa-total-conversations">{{ number_format($totalConversations) }}</div>
                            <div class="wa-stat-label">{{ __('whatsapp_total_conversations') }}</div>
                            <div class="small text-muted mt-1">
                                <span id="wa-new-conversations">{{ number_format($newConversations) }}</span> {{ __('whatsapp_new_conversations') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 wa-stat-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="wa-stat-icon"><i class="ti ti-chart-arcs" aria-hidden="true"></i></span>
                        <div class="min-w-0">
                            <div class="wa-stat-value" id="wa-response-rate">{{ $responseRate === null ? '—' : $responseRate . '%' }}</div>
                            <div class="wa-stat-label">{{ __('whatsapp_response_rate') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 wa-stat-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="wa-stat-icon"><i class="ti ti-clock" aria-hidden="true"></i></span>
                        <div class="min-w-0">
                            <div class="wa-stat-value" id="wa-avg-response">{{ $avgResponseHuman ?? '—' }}</div>
                            <div class="wa-stat-label">{{ __('whatsapp_avg_response') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-light">
                        <strong>{{ __('whatsapp_conversations_over_time') }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="wa-trend" id="wa-trend"></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-light">
                        <strong>{{ __('whatsapp_conversation_sources') }}</strong>
                    </div>
                    <div class="card-body" id="wa-sources"></div>
                </div>
            </div>
        </div>
    </div>
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
                    trendEl.innerHTML = '<div class="text-muted w-100 text-center py-4">' + escapeHtml(tNoData) + '</div>';
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
                    sourcesEl.innerHTML = '<div class="text-muted text-center py-4">' + escapeHtml(tNoData) + '</div>';
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
                        '<div class="progress" role="progressbar" aria-valuenow="' + pct + '" aria-valuemin="0" aria-valuemax="100" style="height:8px">' +
                        '<div class="progress-bar" style="width:' + pct + '%"></div>' +
                        '</div>' +
                        '</div>';
                }).join('');
            }

            function render(data) {
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
                    button.classList.toggle('btn-primary', isActive);
                    button.classList.toggle('btn-outline-primary', !isActive);
                    button.classList.toggle('is-active', isActive);
                });
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

            renderTrend(@json($trend));
            renderSources(@json($sources), @json($sourcesPct));
        })();
    </script>
@endsection
