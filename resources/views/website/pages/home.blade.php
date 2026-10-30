@extends('website.layouts.app')

@section('page_key', 'index.html')
@section('title', 'الرئيسية — SANAD CX')
@section('meta_description', 'فريق متخصص يتكامل مباشرة مع أنظمة الاتصالات والواتساب والمنصات الحالية لديك، لإدارة تفاعلات العملاء بكفاءة وتحقيق نتائج ملموسة.')
@section('og_title', 'الرئيسية — SANAD CX')
@section('og_description', 'فريق متخصص يتكامل مباشرة مع أنظمة الاتصالات والواتساب والمنصات الحالية لديك، لإدارة تفاعلات العملاء بكفاءة وتحقيق نتائج ملموسة.')

@section('content')
    <section class="sanad-hero" aria-labelledby="sanad-hero-heading">
        <div class="sanad-hero__content">
            <div class="sanad-hero__message">
                <p class="sanad-hero__eyebrow">{{ __('auth.hero_eyebrow') }}</p>
                <h1 class="sanad-hero__headline" id="sanad-hero-heading">{{ __('auth.hero_headline') }}<br><span class="sanad-hero__headline-accent">{{ __('auth.hero_headline_accent') }}</span></h1>
                <p class="sanad-hero__description">{{ __('auth.hero_description') }}</p>
            </div>
            <div class="sanad-hero__actions">
                <button type="button" class="sanad-btn sanad-hero__cta" data-consultation-open>{{ __('auth.hero_cta_primary') }}</button>
                <a class="sanad-btn sanad-btn--outline sanad-hero__cta-outline" href="{{ route('website.how-it-works') }}">{{ __('auth.hero_cta_secondary') }}</a>
            </div>
            <ul class="sanad-hero__trust">
                <li class="sanad-hero__trust-item">
                    <img class="sanad-hero__trust-icon" src="{{ asset('website/assets/image/svg/dataSecurityIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
                    <span class="sanad-hero__trust-copy">
                        <span class="sanad-hero__trust-title">{{ __('auth.hero_trust_data_title') }}</span>
                        <span class="sanad-hero__trust-detail">{{ __('auth.hero_trust_data_detail') }}</span>
                    </span>
                </li>
                <li class="sanad-hero__trust-divider" aria-hidden="true"></li>
                <li class="sanad-hero__trust-item">
                    <img class="sanad-hero__trust-icon" src="{{ asset('website/assets/image/svg/directIntegrationIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
                    <span class="sanad-hero__trust-copy">
                        <span class="sanad-hero__trust-title">{{ __('auth.hero_trust_integration_title') }}</span>
                        <span class="sanad-hero__trust-detail">{{ __('auth.hero_trust_integration_detail') }}</span>
                    </span>
                </li>
                <li class="sanad-hero__trust-divider" aria-hidden="true"></li>
                <li class="sanad-hero__trust-item">
                    <img class="sanad-hero__trust-icon" src="{{ asset('website/assets/image/svg/fastLaunchIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
                    <span class="sanad-hero__trust-copy">
                        <span class="sanad-hero__trust-title">{{ __('auth.hero_trust_launch_title') }}</span>
                        <span class="sanad-hero__trust-detail">{{ __('auth.hero_trust_launch_detail') }}</span>
                    </span>
                </li>
            </ul>
        </div>
        <div class="sanad-hero__visual" aria-hidden="true">
            <span class="sanad-hero__glow"></span>
            <img class="sanad-hero__grid" src="{{ asset('website/assets/image/svg/technicalGridPattern_519x640.svg') }}" alt="" width="519" height="640" decoding="async">
            <picture class="sanad-hero__globe-picture">
                <source type="image/webp" srcset="{{ asset('website/assets/image/webp/globeIllustration_494x494.webp') }}">
                <img class="sanad-hero__globe" src="{{ asset('website/assets/image/png/globeIllustration_494x494.png') }}" alt="" width="494" height="494" fetchpriority="high" decoding="async">
            </picture>
            <img class="sanad-hero__connections" src="{{ asset('website/assets/image/svg/channelConnectionLayer_370x365.svg') }}" alt="" width="371" height="366" decoding="async">
            <span class="sanad-hero__chip sanad-hero__chip--phone"><img src="{{ asset('website/assets/image/svg/phoneOperationsIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async"></span>
            <span class="sanad-hero__chip sanad-hero__chip--chat"><img src="{{ asset('website/assets/image/svg/whatsappChatIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async"></span>
            <span class="sanad-hero__chip sanad-hero__chip--support"><img src="{{ asset('website/assets/image/svg/customerSupportIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async"></span>
            <span class="sanad-hero__chip sanad-hero__chip--crm"><img src="{{ asset('website/assets/image/svg/crmSystemsIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async"></span>
            <span class="sanad-hero__chip sanad-hero__chip--analytics"><img src="{{ asset('website/assets/image/svg/performanceAnalyticsIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async"></span>
        </div>
    </section>
    <section class="sanad-stats" aria-label="{{ __('auth.stats_aria_label') }}">
        <ul class="sanad-stats__list">
            <li class="sanad-stats__item"><span class="sanad-stats__value" dir="ltr">&lt; 60s</span> <span class="sanad-stats__label">{{ __('auth.stats_speed_title') }}</span> <span class="sanad-stats__detail">{{ __('auth.stats_speed_desc') }}</span>
            </li>
            <li class="sanad-stats__item"><span class="sanad-stats__value" dir="ltr">100%</span> <span class="sanad-stats__label">{{ __('auth.stats_integration_title') }}</span> <span class="sanad-stats__detail">{{ __('auth.stats_integration_desc') }}</span>
            </li>
            <li class="sanad-stats__item"><span class="sanad-stats__value" dir="ltr">40%</span> <span class="sanad-stats__label">{{ __('auth.stats_efficiency_title') }}</span> <span class="sanad-stats__detail">{{ __('auth.stats_efficiency_desc') }}</span>
            </li>
            <li class="sanad-stats__item"><span class="sanad-stats__value" dir="ltr">+35%</span> <span class="sanad-stats__label">{{ __('auth.stats_growth_title') }}</span> <span class="sanad-stats__detail">{{ __('auth.stats_growth_desc') }}</span>
            </li>
        </ul>
    </section>
    <section class="sanad-integration" aria-labelledby="sanad-integration-heading">
        <div class="sanad-integration__container">
            <div class="sanad-integration__header"><h2 class="sanad-integration__title" id="sanad-integration-heading">
                    {{ __('auth.integration_title_before') }} <span class="sanad-integration__title-accent">{{ __('auth.integration_title_accent') }}</span> {{ __('auth.integration_title_after') }}</h2>
                <p class="sanad-integration__description">{{ __('auth.integration_description') }}</p></div>
            <ul class="sanad-integration__benefits">
                <li class="sanad-integration__benefit"><img class="sanad-integration__benefit-icon"
                                                            src="{{ asset('website/assets/image/png/dataProtectionIllustration_auto.png') }}"
                                                            alt="" width="53" height="48" decoding="async">
                    <div class="sanad-integration__benefit-copy"><h3
                            class="sanad-integration__benefit-title sanad-integration__benefit-title--accent">{{ __('auth.integration_benefit1_title') }}</h3>
                        <p class="sanad-integration__benefit-description">{{ __('auth.integration_benefit1_desc') }}</p></div>
                </li>
                <li class="sanad-integration__benefit"><img class="sanad-integration__benefit-icon"
                                                            src="{{ asset('website/assets/image/png/userGrowthIllustration_auto.png') }}"
                                                            alt="" width="53" height="48" decoding="async">
                    <div class="sanad-integration__benefit-copy"><h3 class="sanad-integration__benefit-title">{{ __('auth.integration_benefit2_title') }}</h3>
                        <p class="sanad-integration__benefit-description">{{ __('auth.integration_benefit2_desc') }}</p></div>
                </li>
                <li class="sanad-integration__benefit"><img class="sanad-integration__benefit-icon"
                                                            src="{{ asset('website/assets/image/png/noSetupFeesIllustration_auto.png') }}"
                                                            alt="" width="47" height="48" decoding="async">
                    <div class="sanad-integration__benefit-copy"><h3 class="sanad-integration__benefit-title">{{ __('auth.integration_benefit3_title') }}</h3>
                        <p class="sanad-integration__benefit-description">{{ __('auth.integration_benefit3_desc') }}</p>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <section class="sanad-comparison" aria-labelledby="sanad-comparison-heading">
        <div class="sanad-comparison__container">
            <div class="sanad-comparison__header">
                <h2 class="sanad-comparison__title" id="sanad-comparison-heading">{{ __('auth.comparison_heading_before') }} <span
                        class="sanad-comparison__title-accent">Sanad CX</span>{{ __('auth.comparison_heading_after') }}</h2>
                <p class="sanad-comparison__intro">{{ __('auth.comparison_intro') }}</p>
            </div>
            @if($whyChooseUs->isNotEmpty())
                <ul class="sanad-comparison__cards">
                    @foreach($whyChooseUs as $item)
                        <li class="sanad-comparison__card {{ $item->is_featured ? 'sanad-comparison__card--sanad' : '' }} sanad-card-hoverable">
                            <div class="sanad-comparison__card-head">
                                <h3 class="sanad-comparison__card-title">{{ $item->title }}</h3>
                                @if($item->subtitle)
                                    <p class="sanad-comparison__card-subtitle">{{ $item->subtitle }}</p>
                                @endif
                            </div>
                            @if($item->features->isNotEmpty())
                                <dl class="sanad-comparison__criteria">
                                    @foreach($item->features as $feature)
                                        <div class="sanad-comparison__criterion">
                                            <dt class="sanad-comparison__criterion-label">{{ $feature->title }}</dt>
                                            <dd class="sanad-comparison__criterion-value">{{ $feature->description }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            @endif
                            <div class="sanad-card-hover-overlay" aria-hidden="true"></div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>
    <section class="sanad-home-services" aria-labelledby="sanad-home-services-heading">
        <div class="sanad-home-services__header"><h2 class="sanad-home-services__title"
                                                     id="sanad-home-services-heading">{{ __('auth.services_heading_before') }} <span class="sanad-home-services__title-accent">{{ __('auth.services_heading_accent') }}</span></h2>
            <p class="sanad-home-services__intro">{{ __('auth.services_intro') }}</p></div>
        <ul class="sanad-home-services__grid">
            <li class="sanad-service-card sanad-home-services__card"><img class="sanad-service-card__icon"
                                                                          src="{{ asset('website/assets/image/svg/Service-Icon-logistics_48x48.svg') }}"
                                                                          alt="" width="48" height="48"
                                                                          decoding="async">
                <div class="sanad-service-card__copy">
                    <div class="sanad-home-services__title-area"><h3 class="sanad-service-card__title">{{ __('auth.services_card1_title') }}</h3></div>
                    <div class="sanad-home-services__desc-area"><p class="sanad-service-card__desc">{{ __('auth.services_card1_desc') }}</p></div>
                </div>
                <div class="sanad-service-card__compat">
                    <div class="sanad-service-card__compat-divider" aria-hidden="true"></div>
                    <p class="sanad-service-card__compat-label">{{ __('auth.services_compat_label') }}</p>
                    <div class="sanad-service-card__chips"><span class="sanad-service-card__chip" lang="en" dir="ltr">SMSA</span>
                        <span class="sanad-service-card__chip" lang="en" dir="ltr">Aramex</span> <span
                            class="sanad-service-card__chip" lang="en" dir="ltr">Torod</span> <span
                            class="sanad-service-card__chip" lang="en" dir="ltr">Oto</span></div>
                </div>
            </li>
            <li class="sanad-service-card sanad-home-services__card"><img class="sanad-service-card__icon"
                                                                          src="{{ asset('website/assets/image/svg/Service-Icon-messaging_48x48.svg') }}"
                                                                          alt="" width="48" height="48"
                                                                          decoding="async">
                <div class="sanad-service-card__copy">
                    <div class="sanad-home-services__title-area"><h3 class="sanad-service-card__title">{{ __('auth.services_card2_title') }}</h3></div>
                    <div class="sanad-home-services__desc-area"><p class="sanad-service-card__desc">{{ __('auth.services_card2_desc') }}</p></div>
                </div>
                <div class="sanad-service-card__compat">
                    <div class="sanad-service-card__compat-divider" aria-hidden="true"></div>
                    <p class="sanad-service-card__compat-label">{{ __('auth.services_compat_label') }}</p>
                    <div class="sanad-service-card__chips"><span class="sanad-service-card__chip" lang="en" dir="ltr">MessageBird</span>
                        <span class="sanad-service-card__chip" lang="en" dir="ltr">Unifonic</span> <span
                            class="sanad-service-card__chip" lang="en" dir="ltr">Intercom</span></div>
                </div>
            </li>
            <li class="sanad-service-card sanad-home-services__card"><img class="sanad-service-card__icon"
                                                                          src="{{ asset('website/assets/image/svg/Service-Icon-growth_48x48.svg') }}"
                                                                          alt="" width="48" height="48"
                                                                          decoding="async">
                <div class="sanad-service-card__copy">
                    <div class="sanad-home-services__title-area"><h3 class="sanad-service-card__title">{{ __('auth.services_card3_title') }}</h3></div>
                    <div class="sanad-home-services__desc-area"><p class="sanad-service-card__desc">{{ __('auth.services_card3_desc') }}</p></div>
                </div>
                <div class="sanad-service-card__compat">
                    <div class="sanad-service-card__compat-divider" aria-hidden="true"></div>
                    <p class="sanad-service-card__compat-label">{{ __('auth.services_compat_label') }}</p>
                    <div class="sanad-service-card__chips"><span class="sanad-service-card__chip" lang="en" dir="ltr">Zid</span>
                        <span class="sanad-service-card__chip" lang="en" dir="ltr">Zid</span> <span
                            class="sanad-service-card__chip" lang="en" dir="ltr">Salla</span> <span
                            class="sanad-service-card__chip" lang="en" dir="ltr">Shopify</span></div>
                </div>
            </li>
            <li class="sanad-service-card sanad-home-services__card"><img class="sanad-service-card__icon"
                                                                          src="{{ asset('website/assets/image/svg/Service-Icon-support_48x48.svg') }}"
                                                                          alt="" width="48" height="48"
                                                                          decoding="async">
                <div class="sanad-service-card__copy">
                    <div class="sanad-home-services__title-area"><h3 class="sanad-service-card__title">{{ __('auth.services_card4_title') }}</h3></div>
                    <div class="sanad-home-services__desc-area"><p class="sanad-service-card__desc">{{ __('auth.services_card4_desc') }}</p></div>
                </div>
                <div class="sanad-service-card__compat">
                    <div class="sanad-service-card__compat-divider" aria-hidden="true"></div>
                    <p class="sanad-service-card__compat-label">{{ __('auth.services_compat_label') }}</p>
                    <div class="sanad-service-card__chips"><span class="sanad-service-card__chip" lang="en" dir="ltr">Zendesk</span>
                        <span class="sanad-service-card__chip" lang="en" dir="ltr">Salesforce</span> <span
                            class="sanad-service-card__chip" lang="en" dir="ltr">Zoho</span> <span
                            class="sanad-service-card__chip" lang="en" dir="ltr">Freshdesk</span></div>
                </div>
            </li>
        </ul>
        <div class="sanad-home-services__edge" aria-hidden="true">
            <div class="sanad-home-services__edge-layer" data-node-id="89:16023" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16027" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16031" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16035" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16039" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16043" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16047" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16051" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16055" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16059" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16063" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16067" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16071" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16075" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16079" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16083" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16087" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16091" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16095" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16099" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16103" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16107" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16111" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16115" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16119" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16123" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16127" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16131" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16135" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16139" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16143" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16147" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16151" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16155" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16159" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16163" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16167" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16171" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16175" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16179" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16183" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16187" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16191" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-home-services__edge-layer" data-node-id="89:16195" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
        </div>
    </section>
    <section class="sanad-testimonials" aria-labelledby="sanad-testimonials-heading">
        <div class="sanad-testimonials__header">
            <h2 class="sanad-testimonials__title" id="sanad-testimonials-heading">{{ __('auth.testimonials_heading') }}</h2>
        </div>
        @if($clientReviewSlides->isNotEmpty())
        @php($slideCount = $clientReviewSlides->count())
        <div class="sanad-testimonials__carousel" data-carousel role="region" aria-roledescription="carousel" aria-label="{{ __('auth.testimonials_carousel_label') }}" tabindex="0">
            <div class="sanad-testimonials__viewport" data-carousel-viewport>
                <div class="sanad-testimonials__track" data-carousel-track>
                    @foreach($clientReviewSlides as $slideIndex => $slide)
                    <div class="sanad-testimonials__slide" data-carousel-slide {{ $slideIndex === 0 ? 'data-carousel-active' : '' }} role="group" aria-roledescription="slide" aria-label="{{ $slideIndex + 1 }} من {{ $slideCount }}">
                        @foreach($slide as $review)
                        <article class="sanad-testimonials__card">
                            <div class="sanad-testimonials__industry">
                                <img class="sanad-testimonials__industry-icon sanad-testimonials__industry-icon--light" src="{{ asset('website/assets/image/svg/Illustrative-Industry-Icon_40x40_homepage-light.svg') }}" alt="" width="40" height="40" decoding="async">
                                <img class="sanad-testimonials__industry-icon sanad-testimonials__industry-icon--dark" src="{{ asset('website/assets/image/svg/Illustrative-Industry-Icon_40x40_homepage-dark.svg') }}" alt="" width="40" height="40" aria-hidden="true" decoding="async">
                                <p class="sanad-testimonials__industry-label">{{ $review->job }}، {{ $review->company_name }}</p>
                            </div>
                            <div class="sanad-testimonials__quotation">
                                <blockquote class="sanad-testimonials__quote">"{{ $review->review_message }}"</blockquote>
                            </div>
                            <div class="sanad-testimonials__author">
                                <span class="sanad-testimonials__divider" aria-hidden="true"></span>
                                <h3 class="sanad-testimonials__name">{{ $review->name }}</h3>
                                <p class="sanad-testimonials__role">{{ $review->job }}، {{ $review->company_name }}</p>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="sanad-testimonials__controls">
                <div class="sanad-testimonials__controls-group">
                    <button type="button" class="sanad-testimonials__arrow" data-carousel-prev aria-label="{{ __('auth.testimonials_prev') }}">
                        <img class="sanad-testimonials__chevron sanad-testimonials__chevron--light sanad-testimonials__chevron--previous" src="{{ asset('website/assets/image/svg/Navigation-Chevron_24x24_homepage-light.svg') }}" alt="" width="24" height="24" decoding="async">
                        <img class="sanad-testimonials__chevron sanad-testimonials__chevron--dark sanad-testimonials__chevron--previous" src="{{ asset('website/assets/image/svg/Navigation-Chevron_24x24_homepage-dark.svg') }}" alt="" width="24" height="24" aria-hidden="true" decoding="async">
                    </button>
                    <div class="sanad-testimonials__dots" role="group" aria-label="{{ __('auth.testimonials_dots_label') }}">
                        @foreach($clientReviewSlides as $dotIndex => $unused)
                        <button type="button" class="sanad-testimonials__dot" data-carousel-dot="{{ $dotIndex + 1 }}" aria-label="الانتقال إلى الشريحة {{ $dotIndex + 1 }}" {!! $dotIndex === 0 ? 'aria-current="true"' : '' !!}>
                            <span class="sanad-testimonials__dot-marker"></span>
                        </button>
                        @endforeach
                    </div>
                    <button type="button" class="sanad-testimonials__arrow" data-carousel-next aria-label="{{ __('auth.testimonials_next') }}">
                        <img class="sanad-testimonials__chevron sanad-testimonials__chevron--light" src="{{ asset('website/assets/image/svg/Navigation-Chevron_24x24_homepage-light.svg') }}" alt="" width="24" height="24" decoding="async">
                        <img class="sanad-testimonials__chevron sanad-testimonials__chevron--dark" src="{{ asset('website/assets/image/svg/Navigation-Chevron_24x24_homepage-dark.svg') }}" alt="" width="24" height="24" aria-hidden="true" decoding="async">
                    </button>
                </div>
            </div>
            <p class="sanad-visually-hidden" data-carousel-status aria-live="polite">الشريحة 1 من {{ $slideCount }}</p>
        </div>
        @endif
    </section>
    <section class="sanad-home-steps" aria-labelledby="sanad-home-steps-title" data-node-id="85:10442">
        <div class="sanad-home-steps__header" data-node-id="85:10443"><h2 class="sanad-home-steps__title"
                                                                          id="sanad-home-steps-title"
                                                                          data-node-id="85:10444">{{ __('auth.steps_heading') }}</h2>
            <p class="sanad-home-steps__description" data-node-id="85:10445">{{ __('auth.steps_description') }}</p></div>
        <div class="sanad-home-steps__timeline" data-node-id="I85:10446;139:13609" role="group"
             aria-label="{{ __('auth.steps_timeline_label') }}">
            <div class="sanad-home-steps__card" role="button" tabindex="0" aria-pressed="false"
                 data-node-id="I85:10446;139:13626"><span class="sanad-home-steps__milestone" aria-hidden="true"></span>
                <div class="sanad-home-steps__identity" data-node-id="I85:10446;139:13626;139:13020"><span
                        class="sanad-home-steps__icon" data-node-id="I85:10446;139:13626;139:13024"> <img
                            class="sanad-home-steps__icon-img"
                            src="{{ asset('website/assets/image/svg/Editable-Analysis-Icon_32x32.svg') }}" alt=""
                            width="32" height="32" data-node-id="I85:10446;139:13626;139:13025"> </span> <span
                        class="sanad-home-steps__number-wrap" data-node-id="I85:10446;139:13626;139:13021"> <span
                            class="sanad-home-steps__number"
                            data-node-id="I85:10446;139:13626;139:13022">01</span> <span class="sanad-home-steps__stage"
                                                                                         data-node-id="I85:10446;139:13626;139:13023"
                                                                                         lang="en" dir="ltr">STEP</span> </span>
                </div>
                <div class="sanad-home-steps__content" data-node-id="I85:10446;139:13626;139:13026"><h3
                        class="sanad-home-steps__card-title" data-node-id="I85:10446;139:13626;139:13028">{{ __('auth.steps_step1_title') }}</h3>
                    <p class="sanad-home-steps__card-description" data-node-id="I85:10446;139:13626;139:13030">{{ __('auth.steps_step1_desc') }}</p></div>
                <div class="sanad-home-steps__summary" data-node-id="I85:10446;139:13626;139:13031"><span
                        class="sanad-home-steps__summary-text"
                        data-node-id="I85:10446;139:13626;139:13034">{{ __('auth.steps_step1_summary') }}</span> <img
                        class="sanad-home-steps__summary-icon"
                        src="{{ asset('website/assets/image/svg/Summary-Direction-Icon_16x16.svg') }}" alt="" width="16"
                        height="16" data-node-id="I85:10446;139:13626;139:13032"></div>
            </div>
            <div class="sanad-home-steps__connector" data-node-id="I85:10446;139:13622" aria-hidden="true">
                <svg class="sanad-home-steps__arrow" data-node-id="I85:10446;139:13624" width="24" height="10"
                     viewBox="0 0 24 10" fill="none" focusable="false">
                    <path d="M23 5H1M6.5 1 1 5l5.5 4" stroke="var(--sanad-blue-800-alpha-65)" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="sanad-home-steps__card" role="button" tabindex="0" aria-pressed="false"
                 data-node-id="I85:10446;139:13621"><span class="sanad-home-steps__milestone" aria-hidden="true"></span>
                <div class="sanad-home-steps__identity" data-node-id="I85:10446;139:13621;139:13020"><span
                        class="sanad-home-steps__icon" data-node-id="I85:10446;139:13621;139:13024"> <img
                            class="sanad-home-steps__icon-img"
                            src="{{ asset('website/assets/image/svg/Editable-Security-Icon_32x32.svg') }}" alt=""
                            width="32" height="32" data-node-id="I85:10446;139:13621;139:13025"> </span> <span
                        class="sanad-home-steps__number-wrap" data-node-id="I85:10446;139:13621;139:13021"> <span
                            class="sanad-home-steps__number"
                            data-node-id="I85:10446;139:13621;139:13022">02</span> <span class="sanad-home-steps__stage"
                                                                                         data-node-id="I85:10446;139:13621;139:13023"
                                                                                         lang="en" dir="ltr">STEP</span> </span>
                </div>
                <div class="sanad-home-steps__content" data-node-id="I85:10446;139:13621;139:13026"><h3
                        class="sanad-home-steps__card-title" data-node-id="I85:10446;139:13621;139:13028">{{ __('auth.steps_step2_title') }}</h3>
                    <p class="sanad-home-steps__card-description" data-node-id="I85:10446;139:13621;139:13030">{{ __('auth.steps_step2_desc') }}</p></div>
                <div class="sanad-home-steps__summary" data-node-id="I85:10446;139:13621;139:13031"><span
                        class="sanad-home-steps__summary-text" data-node-id="I85:10446;139:13621;139:13034">{{ __('auth.steps_step2_summary') }}</span>
                    <img class="sanad-home-steps__summary-icon"
                         src="{{ asset('website/assets/image/svg/Summary-Direction-Icon_16x16.svg') }}" alt=""
                         width="16" height="16" data-node-id="I85:10446;139:13621;139:13032"></div>
            </div>
            <div class="sanad-home-steps__connector" data-node-id="I85:10446;139:13617" aria-hidden="true">
                <svg class="sanad-home-steps__arrow" data-node-id="I85:10446;139:13619" width="24" height="10"
                     viewBox="0 0 24 10" fill="none" focusable="false">
                    <path d="M23 5H1M6.5 1 1 5l5.5 4" stroke="var(--sanad-blue-800-alpha-65)" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="sanad-home-steps__card" role="button" tabindex="0" aria-pressed="false"
                 data-node-id="I85:10446;139:13616"><span class="sanad-home-steps__milestone" aria-hidden="true"></span>
                <div class="sanad-home-steps__identity" data-node-id="I85:10446;139:13616;139:13020"><span
                        class="sanad-home-steps__icon" data-node-id="I85:10446;139:13616;139:13024"> <img
                            class="sanad-home-steps__icon-img"
                            src="{{ asset('website/assets/image/svg/Editable-Training-Icon_32x32.svg') }}" alt=""
                            width="32" height="32" data-node-id="I85:10446;139:13616;139:13025"> </span> <span
                        class="sanad-home-steps__number-wrap" data-node-id="I85:10446;139:13616;139:13021"> <span
                            class="sanad-home-steps__number"
                            data-node-id="I85:10446;139:13616;139:13022">03</span> <span class="sanad-home-steps__stage"
                                                                                         data-node-id="I85:10446;139:13616;139:13023"
                                                                                         lang="en" dir="ltr">STEP</span> </span>
                </div>
                <div class="sanad-home-steps__content" data-node-id="I85:10446;139:13616;139:13026"><h3
                        class="sanad-home-steps__card-title" data-node-id="I85:10446;139:13616;139:13028">{{ __('auth.steps_step3_title') }}</h3>
                    <p class="sanad-home-steps__card-description" data-node-id="I85:10446;139:13616;139:13030">{{ __('auth.steps_step3_desc') }}</p></div>
                <div class="sanad-home-steps__summary" data-node-id="I85:10446;139:13616;139:13031"><span
                        class="sanad-home-steps__summary-text"
                        data-node-id="I85:10446;139:13616;139:13034">{{ __('auth.steps_step3_summary') }}</span> <img
                        class="sanad-home-steps__summary-icon"
                        src="{{ asset('website/assets/image/svg/Summary-Direction-Icon_16x16.svg') }}" alt="" width="16"
                        height="16" data-node-id="I85:10446;139:13616;139:13032"></div>
            </div>
            <div class="sanad-home-steps__connector" data-node-id="I85:10446;139:13612" aria-hidden="true">
                <svg class="sanad-home-steps__arrow" data-node-id="I85:10446;139:13614" width="24" height="10"
                     viewBox="0 0 24 10" fill="none" focusable="false">
                    <path d="M23 5H1M6.5 1 1 5l5.5 4" stroke="var(--sanad-blue-800-alpha-65)" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="sanad-home-steps__card sanad-home-steps__card--active" role="button" tabindex="0"
                 aria-pressed="true" data-node-id="I85:10446;139:13611"><span class="sanad-home-steps__milestone"
                                                                              aria-hidden="true"
                                                                              data-node-id="I85:10446;139:13611;139:13067"></span>
                <div class="sanad-home-steps__identity" data-node-id="I85:10446;139:13611;139:13052"><span
                        class="sanad-home-steps__icon" data-node-id="I85:10446;139:13611;139:13056"> <img
                            class="sanad-home-steps__icon-img"
                            src="{{ asset('website/assets/image/svg/Editable-Launch-Icon_32x32.svg') }}" alt=""
                            width="32" height="32" data-node-id="I85:10446;139:13611;139:13057"> </span> <span
                        class="sanad-home-steps__number-wrap" data-node-id="I85:10446;139:13611;139:13053"> <span
                            class="sanad-home-steps__number"
                            data-node-id="I85:10446;139:13611;139:13054">04</span> <span class="sanad-home-steps__stage"
                                                                                         data-node-id="I85:10446;139:13611;139:13055"
                                                                                         lang="en"
                                                                                         dir="ltr">MILESTONE</span> </span>
                </div>
                <div class="sanad-home-steps__content" data-node-id="I85:10446;139:13611;139:13058"><h3
                        class="sanad-home-steps__card-title" data-node-id="I85:10446;139:13611;139:13060">{{ __('auth.steps_step4_title') }}</h3>
                    <p class="sanad-home-steps__card-description" data-node-id="I85:10446;139:13611;139:13062">{{ __('auth.steps_step4_desc') }}</p></div>
                <div class="sanad-home-steps__summary" data-node-id="I85:10446;139:13611;139:13063"><span
                        class="sanad-home-steps__summary-text"
                        data-node-id="I85:10446;139:13611;139:13066">{{ __('auth.steps_step4_summary') }}</span> <img
                        class="sanad-home-steps__summary-icon"
                        src="{{ asset('website/assets/image/svg/Summary-Direction-Icon_16x16.svg') }}" alt="" width="16"
                        height="16" data-node-id="I85:10446;139:13611;139:13064"></div>
            </div>
        </div>
        <div class="sanad-home-steps__band" data-node-id="85:10447">
            <div class="sanad-home-steps__fact" data-node-id="85:10458"><img class="sanad-home-steps__fact-icon"
                                                                             src="{{ asset('website/assets/image/svg/Editable-Launch-Icon_32x32.svg') }}"
                                                                             alt="" width="32" height="32"
                                                                             data-node-id="I85:10462;139:13150">
                <div class="sanad-home-steps__fact-copy" data-node-id="85:10459"><p class="sanad-home-steps__fact-title"
                                                                                    data-node-id="85:10460">{{ __('auth.steps_fact1_title') }}</p>
                    <p class="sanad-home-steps__fact-text" data-node-id="85:10461">{{ __('auth.steps_fact1_text') }}</p></div>
            </div>
            <div class="sanad-home-steps__fact" data-node-id="85:10453"><img class="sanad-home-steps__fact-icon"
                                                                             src="{{ asset('website/assets/image/svg/Editable-Security-Icon_32x32.svg') }}"
                                                                             alt="" width="32" height="32"
                                                                             data-node-id="I85:10457;139:13142">
                <div class="sanad-home-steps__fact-copy" data-node-id="85:10454"><p class="sanad-home-steps__fact-title"
                                                                                    data-node-id="85:10455">{{ __('auth.steps_fact2_title') }}</p>
                    <p class="sanad-home-steps__fact-text" data-node-id="85:10456">{{ __('auth.steps_fact2_text') }}</p>
                </div>
            </div>
            <div class="sanad-home-steps__fact" data-node-id="85:10448"><img class="sanad-home-steps__fact-icon"
                                                                             src="{{ asset('website/assets/image/svg/Editable-Analysis-Icon_32x32.svg') }}"
                                                                             alt="" width="32" height="32"
                                                                             data-node-id="I85:10452;139:13138">
                <div class="sanad-home-steps__fact-copy" data-node-id="85:10449"><p class="sanad-home-steps__fact-title"
                                                                                    data-node-id="85:10450">{{ __('auth.steps_fact3_title') }}</p>
                    <p class="sanad-home-steps__fact-text" data-node-id="85:10451">{{ __('auth.steps_fact3_text') }}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="sanad-calculator" id="package-calculator" aria-labelledby="sanad-calculator-title"
             data-node-id="136:11539" data-sanad-calculator>
        <div class="sanad-calculator__header" data-node-id="136:11540"><h2 class="sanad-calculator__title"
                                                                           id="sanad-calculator-title"
                                                                           data-node-id="136:11541">{{ __('auth.calc_heading_before') }} <span>{{ __('auth.calc_heading_accent') }}</span>
            </h2>
            <p class="sanad-calculator__description" data-node-id="136:11542">{{ __('auth.calc_description') }}</p></div>
        <div class="sanad-calculator__card" data-node-id="136:11813">
            <div class="sanad-calculator__body" data-node-id="I136:11813;140:14658">
                <div class="sanad-calculator__control" data-node-id="I136:11813;140:14668"><p
                        class="sanad-calculator__label" id="sanad-calculator-volume-label"
                        data-node-id="I136:11813;140:14669">{{ __('auth.calc_volume_label') }}</p>
                    <p class="sanad-calculator__volume" data-node-id="I136:11813;140:14670" data-calculator-value>
                        100</p>
                    <p class="sanad-calculator__unit" data-node-id="I136:11813;140:14671">{{ __('auth.calc_unit') }}</p>
                    <div class="sanad-calculator__range" dir="ltr" data-node-id="I136:11813;140:14672"
                         data-calculator-range><span class="sanad-calculator__track"
                                                     data-node-id="I136:11813;140:14673"></span> <span
                            class="sanad-calculator__fill" data-node-id="I136:11813;140:14674"></span> <span
                            class="sanad-calculator__stop" data-node-id="I136:11813;140:14675"
                            aria-hidden="true"></span> <span class="sanad-calculator__stop"
                                                             data-node-id="I136:11813;140:14676"
                                                             aria-hidden="true"></span> <span
                            class="sanad-calculator__stop" data-node-id="I136:11813;140:14677"
                            aria-hidden="true"></span> <span class="sanad-calculator__stop"
                                                             data-node-id="I136:11813;140:14678"
                                                             aria-hidden="true"></span>
                        <div class="sanad-calculator__thumb" role="slider" tabindex="0"
                             aria-labelledby="sanad-calculator-volume-label" aria-valuemin="100" aria-valuemax="5000"
                             aria-valuenow="100" aria-valuetext="100" data-node-id="I136:11813;140:14679"
                             data-calculator-thumb><span class="sanad-calculator__knob"
                                                         data-node-id="I136:11813;140:14680"></span></div>
                    </div>
                    <div class="sanad-calculator__limits" dir="ltr" data-node-id="I136:11813;140:14681"><span
                            data-node-id="I136:11813;140:14682">100</span> <span data-node-id="I136:11813;140:14683">5,000</span>
                    </div>
                    <div class="sanad-calculator__presets" dir="ltr" data-node-id="I136:11813;140:14684">
                        <button type="button" class="sanad-calculator__preset" data-calculator-preset="100"
                                aria-pressed="true" data-node-id="I136:11813;140:14685"><span
                                data-node-id="I136:11813;140:14686">100</span></button>
                        <button type="button" class="sanad-calculator__preset" data-calculator-preset="1000"
                                aria-pressed="false" data-node-id="I136:11813;140:14687"><span
                                data-node-id="I136:11813;140:14688">1,000</span></button>
                        <button type="button" class="sanad-calculator__preset" data-calculator-preset="2500"
                                aria-pressed="false" data-node-id="I136:11813;140:14689"><span
                                data-node-id="I136:11813;140:14690">2,500</span></button>
                        <button type="button" class="sanad-calculator__preset" data-calculator-preset="5000"
                                aria-pressed="false" data-node-id="I136:11813;140:14691"><span
                                data-node-id="I136:11813;140:14692">5,000</span></button>
                    </div>
                </div>
                <div class="sanad-calculator__outputs" data-node-id="I136:11813;140:14659">
                    <div class="sanad-calculator__output" data-node-id="I136:11813;140:14660"><p
                            class="sanad-calculator__output-label" data-node-id="I136:11813;140:14661">{{ __('auth.calc_output1_label') }}</p>
                        <p class="sanad-calculator__output-value" data-node-id="I136:11813;140:14662">{{ __('auth.calc_output1_value') }}</p>
                        <p class="sanad-calculator__output-note" data-node-id="I136:11813;140:14663">{{ __('auth.calc_output1_note') }}</p></div>
                    <div class="sanad-calculator__output" data-node-id="I136:11813;140:14664"><p
                            class="sanad-calculator__output-label" data-node-id="I136:11813;140:14665">{{ __('auth.calc_output2_label') }}</p>
                        <p class="sanad-calculator__output-value" data-node-id="I136:11813;140:14666">{{ __('auth.calc_output2_value') }}</p>
                        <p class="sanad-calculator__output-note" data-node-id="I136:11813;140:14667">{{ __('auth.calc_output2_note') }}</p></div>
                </div>
            </div>
            <button type="button" class="sanad-calculator__cta" data-consultation-open
                    data-node-id="I136:11813;140:14693"><span data-node-id="I136:11813;140:14694">{{ __('auth.calc_cta') }}</span>
            </button>
        </div>
        <div class="sanad-calculator__edge" data-node-id="136:11549" aria-hidden="true">
            <div class="sanad-calculator__edge-layer" data-node-id="136:11550" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11554" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11558" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11562" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11566" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11570" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11574" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11578" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11582" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11586" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11590" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11594" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11598" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11602" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11606" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11610" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11614" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11618" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11622" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11626" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11630" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11634" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11638" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11642" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11646" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11650" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11654" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11658" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11662" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11666" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11670" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11674" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11678" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11682" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11686" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11690" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11694" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11698" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11702" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11706" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11710" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11714" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11718" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
            <div class="sanad-calculator__edge-layer" data-node-id="136:11722" aria-hidden="true"><img
                    src="{{ asset('website/assets/image/svg/section-edge-layer-alt.svg') }}" alt=""></div>
        </div>
    </section>
    <section class="sanad-faq" id="faq" aria-labelledby="sanad-faq-title">
        <div class="sanad-faq__container">
            <div class="sanad-faq__header"><h2 class="sanad-faq__title" id="sanad-faq-title">
                    <span>{{ __('auth.faqs_heading_1') }} </span><span class="sanad-faq__accent">{{ __('auth.faqs_heading_2') }}</span></h2></div>
            <div class="sanad-faq__list">
                @foreach($faqs as $faqIndex => $faqItem)
                <div class="sanad-faq__item sanad-card-hoverable">
                    <h3 class="sanad-faq__heading">
                        <button type="button" class="sanad-faq__trigger" id="sanad-faq-q{{ $faqIndex + 1 }}" aria-expanded="false"
                                aria-controls="sanad-faq-a{{ $faqIndex + 1 }}"><span
                                class="sanad-faq__question">{{ $faqItem->question }}</span>
                            <span class="sanad-faq__icon" aria-hidden="true"> <img
                                    class="sanad-faq__chevron sanad-faq__chevron--light"
                                    src="{{ asset('website/assets/image/svg/Group_16x8_homepage-light.svg') }}" alt=""
                                    width="16" height="8"> <img
                                    class="sanad-faq__chevron sanad-faq__chevron--dark"
                                    src="{{ asset('website/assets/image/svg/Group_16x8_homepage-dark.svg') }}" alt=""
                                    width="16" height="8"> </span></button>
                    </h3>
                    <div class="sanad-faq__panel" id="sanad-faq-a{{ $faqIndex + 1 }}" role="region" aria-labelledby="sanad-faq-q{{ $faqIndex + 1 }}" hidden>
                        <p class="sanad-faq__answer">{{ $faqItem->answer }}</p></div>
                    <div class="sanad-card-hover-overlay" aria-hidden="true"></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="sanad-privacy-banner" data-node-id="136:8399" aria-labelledby="sanad-privacy-banner-title">
        <div class="sanad-privacy-banner__decor" aria-hidden="true"><span class="sanad-privacy-banner__glow"
                                                                          data-node-id="136:8400"></span><span
                class="sanad-privacy-banner__accent" data-node-id="136:8401"></span></div>
        <div class="sanad-privacy-banner__container" data-node-id="136:8402">
            <div class="sanad-privacy-banner__copy" data-node-id="136:8403"><h2 class="sanad-privacy-banner__title"
                                                                                id="sanad-privacy-banner-title"
                                                                                data-node-id="136:8404">{{ __('auth.privacy_banner_title') }}</h2>
                <p class="sanad-privacy-banner__description" data-node-id="136:8405">{{ __('auth.privacy_banner_description') }}</p></div>
        </div>
        <div class="sanad-privacy-banner__edge sanad-privacy-banner__edge--bottom" data-node-id="136:8406"
             aria-hidden="true">
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8407"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8411"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8415"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8419"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8423"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8427"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8431"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8435"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8439"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8443"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8447"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8451"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8455"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8459"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8463"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8467"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8471"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8475"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8479"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8483"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8487"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8491"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8495"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8499"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8503"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8507"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8511"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8515"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8519"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8523"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8527"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8531"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8535"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8539"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8543"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8547"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8551"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8555"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8559"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8563"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8567"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8571"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8575"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8579"></div>
        </div>
        <div class="sanad-privacy-banner__edge sanad-privacy-banner__edge--top" data-node-id="136:8583"
             aria-hidden="true">
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8584"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8588"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8592"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8596"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8600"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8604"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8608"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8612"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8616"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8620"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8624"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8628"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8632"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8636"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8640"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8644"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8648"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8652"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8656"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8660"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8664"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8668"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8672"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8676"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8680"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8684"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8688"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8692"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8696"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8700"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8704"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8708"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8712"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8716"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8720"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8724"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8728"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8732"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8736"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8740"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8744"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8748"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8752"></div>
            <div class="sanad-privacy-banner__edge-layer" data-node-id="136:8756"></div>
        </div>
        <div class="sanad-privacy-banner__decor" aria-hidden="true">
            <picture class="sanad-privacy-banner__glow-effect-picture">
                <source type="image/webp"
                        srcset="{{ asset('website/assets/image/webp/bannerGlowEffect_184x184.webp') }}">
                <img class="sanad-privacy-banner__glow-effect"
                     src="{{ asset('website/assets/image/png/bannerGlowEffect_184x184.png') }}" alt="" width="184"
                     height="184" decoding="async" data-node-id="136:8760"></picture>
        </div>
    </section>
    <section class="sanad-contact" id="contact" aria-labelledby="sanad-contact-title" data-node-id="85:10840">
        <div class="sanad-contact__container" data-node-id="85:10841">
            <div class="sanad-contact__layout" data-node-id="85:10842">
                <div class="sanad-contact__header" data-node-id="136:8766"><h2 class="sanad-contact__title"
                                                                               id="sanad-contact-title"
                                                                               data-node-id="136:8767">{{ __('auth.contact_title') }}</h2>
                    <p class="sanad-contact__description" data-node-id="136:8768">{{ __('auth.contact_description') }}</p>
                </div>
                <div class="sanad-contact__form-container" data-node-id="85:10843">
                    <form class="sanad-contact__form" data-consultation-form
                          data-action="{{ route('website.consultation.store') }}" novalidate data-node-id="85:10847">
                        <div class="sanad-contact__group" data-node-id="85:10848">
                            <div class="sanad-input" data-node-id="85:10849"><label class="sanad-input__label"
                                                                                    for="sanad-contact-full-name"><span
                                        data-node-id="I85:10849;58:947">{{ __('auth.contact_name_label') }}</span></label>
                                <div class="sanad-input__field" data-node-id="I85:10849;58:924"><input
                                        class="sanad-input__control" id="sanad-contact-full-name" type="text"
                                        name="fullName" placeholder="{{ __('auth.contact_name_label') }}" autocomplete="name"
                                        aria-describedby="sanad-contact-full-name-status"><span
                                        class="sanad-contact__placeholder" aria-hidden="true"
                                        data-node-id="I85:10849;58:929">{{ __('auth.contact_name_label') }}</span></div>
                                <span class="sanad-input__status" id="sanad-contact-full-name-status"
                                      data-consultation-status aria-live="polite">{{ __('auth.contact_field_error') }}</span></div>
                            <div class="sanad-input" data-node-id="85:10850"><label class="sanad-input__label"
                                                                                    for="sanad-contact-company-name"><span
                                        data-node-id="I85:10850;58:947">{{ __('auth.contact_company_label') }}</span></label>
                                <div class="sanad-input__field" data-node-id="I85:10850;58:924"><input
                                        class="sanad-input__control" id="sanad-contact-company-name" type="text"
                                        name="companyName" placeholder="{{ __('auth.contact_company_label') }}"
                                        autocomplete="organization"
                                        aria-describedby="sanad-contact-company-name-status"><span
                                        class="sanad-contact__placeholder" aria-hidden="true"
                                        data-node-id="I85:10850;58:929">{{ __('auth.contact_company_label') }}</span></div>
                                <span class="sanad-input__status" id="sanad-contact-company-name-status"
                                      data-consultation-status aria-live="polite">{{ __('auth.contact_field_error') }}</span></div>
                            <div class="sanad-input" data-node-id="85:10851"><label class="sanad-input__label"
                                                                                    for="sanad-contact-mobile"><span
                                        data-node-id="I85:10851;58:947">{{ __('auth.contact_mobile_label') }}</span></label>
                                <div class="sanad-input__field" data-node-id="I85:10851;58:924"><input
                                        class="sanad-input__control" id="sanad-contact-mobile" type="tel"
                                        name="mobileWhatsapp" inputmode="tel" placeholder="{{ __('auth.contact_mobile_label') }}"
                                        autocomplete="tel" data-consultation-phone pattern="\+?[0-9](?: ?[0-9]){6,14} ?"
                                        aria-describedby="sanad-contact-mobile-status"><span
                                        class="sanad-contact__placeholder" aria-hidden="true"
                                        data-node-id="I85:10851;58:929">{{ __('auth.contact_mobile_label') }}</span></div>
                                <span class="sanad-input__status" id="sanad-contact-mobile-status"
                                      data-consultation-status aria-live="polite">{{ __('auth.contact_field_error') }}</span></div>
                        </div>
                        <div class="sanad-input sanad-input--select" data-node-id="85:10852"><label
                                class="sanad-input__label" for="sanad-contact-volume"><span
                                    data-node-id="I85:10852;58:947">{{ __('auth.contact_volume_label') }}</span></label>
                            <div class="sanad-input__field" data-node-id="I85:10852;58:924"><select
                                    class="sanad-input__control" id="sanad-contact-volume" name="dailyContactVolume"
                                    aria-describedby="sanad-contact-volume-status">
                                    <option value="">{{ __('auth.contact_select_placeholder') }}</option>
                                </select> <span class="sanad-contact__placeholder" aria-hidden="true"
                                                data-node-id="I85:10852;58:929">{{ __('auth.contact_select_placeholder') }}</span> <span
                                    class="sanad-input__toggle sanad-contact__toggle" aria-hidden="true"
                                    data-node-id="I85:10852;58:931"> <img
                                        class="sanad-contact__arrow sanad-contact__arrow--light"
                                        src="{{ asset('website/assets/image/svg/Group_9x5_homepage-light.svg') }}"
                                        alt="" width="9" height="5" data-node-id="I85:10852;58:931;7:282"> <img
                                        class="sanad-contact__arrow sanad-contact__arrow--dark"
                                        src="{{ asset('website/assets/image/svg/Group_9x5_homepage-dark.svg') }}" alt=""
                                        width="9" height="5"> </span></div>
                            <span class="sanad-input__status" id="sanad-contact-volume-status" data-consultation-status
                                  aria-live="polite">{{ __('auth.contact_field_error') }}</span></div>
                        <div class="sanad-input" data-node-id="85:10853"><label class="sanad-input__label"
                                                                                for="sanad-contact-systems"><span
                                    data-node-id="I85:10853;58:947">{{ __('auth.contact_systems_label') }}</span><span
                                    class="sanad-input__optional"
                                    data-node-id="I85:10853;58:925">"{{ __('auth.contact_optional') }}"</span></label>
                            <div class="sanad-input__field" data-node-id="I85:10853;58:924"><input
                                    class="sanad-input__control" id="sanad-contact-systems" type="text"
                                    name="currentSystems" placeholder="{{ __('auth.contact_systems_label') }}"
                                    aria-describedby="sanad-contact-systems-status"><span
                                    class="sanad-contact__placeholder" aria-hidden="true"
                                    data-node-id="I85:10853;58:929">{{ __('auth.contact_systems_label') }}</span>
                            </div>
                            <span class="sanad-input__status" id="sanad-contact-systems-status" data-consultation-status
                                  aria-live="polite">{{ __('auth.contact_field_error') }}</span></div>
                        <p class="sanad-contact__notice" data-consultation-notice
                           data-consultation-notice-text="{{ __('auth.contact_notice_text') }}"
                           role="status" aria-live="polite"></p>
                        <button type="button" class="sanad-btn sanad-contact__submit" data-consultation-submit
                                data-node-id="85:10854">{{ __('auth.contact_submit') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var csrfToken = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
                document.querySelectorAll('[data-consultation-form]').forEach(function (form) {
                    var btn = form.querySelector('[data-consultation-submit]');
                    if (!btn) return;
                    var fresh = btn.cloneNode(true);
                    btn.parentNode.replaceChild(fresh, btn);
                    var actionUrl = form.dataset.action || '';
                    fresh.addEventListener('click', async function () {
                        if (!form.checkValidity()) {
                            var inv = form.querySelector(':invalid');
                            inv && inv.focus();
                            return;
                        }
                        var notice = form.querySelector('[data-consultation-notice]');
                        if (notice) notice.textContent = '';
                        fresh.disabled = true;
                        try {
                            var raw = new FormData(form);
                            var body = new FormData();
                            body.append('_token', csrfToken);
                            body.append('full_name', raw.get('fullName') || '');
                            body.append('company_name', raw.get('companyName') || '');
                            body.append('mobile_whatsapp', raw.get('mobileWhatsapp') || '');
                            body.append('daily_contact_volume', raw.get('dailyContactVolume') || '');
                            body.append('current_systems', raw.get('currentSystems') || '');
                            var res = await fetch(actionUrl, {
                                method: 'POST',
                                headers: {'X-Requested-With': 'XMLHttpRequest'},
                                body: body
                            });
                            var json = await res.json();
                            if (res.ok && json.code === 200) {
                                form.reset();
                                if (window.Swal) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '{{ __('auth.js_success_title') }}',
                                        text: json.message || '{{ __('auth.js_success_text') }}',
                                        confirmButtonText: '{{ __('auth.js_ok_button') }}',
                                        confirmButtonColor: 'var(--sanad-color-primary, #6c5ce7)',
                                        timer: 5000,
                                        timerProgressBar: true
                                    });
                                }
                            } else if (res.status === 422 && json.errors) {
                                if (window.Swal) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{ __('auth.js_validation_title') }}',
                                        text: json.message || '{{ __('auth.js_validation_text') }}',
                                        confirmButtonText: '{{ __('auth.js_ok_button') }}',
                                        confirmButtonColor: 'var(--sanad-color-primary, #6c5ce7)'
                                    });
                                } else {
                                    var msgs = Object.values(json.errors).flat().join(' | ');
                                    if (notice) notice.textContent = msgs;
                                }
                            } else {
                                if (window.Swal) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{ __('auth.js_error_title') }}',
                                        text: json.message || '{{ __('auth.js_error_text') }}',
                                        confirmButtonText: '{{ __('auth.js_ok_button') }}',
                                        confirmButtonColor: 'var(--sanad-color-primary, #6c5ce7)'
                                    });
                                } else if (notice) {
                                    notice.textContent = json.message || '{{ __('auth.js_error_notice') }}';
                                }
                            }
                        } catch (e) {
                            if (window.Swal) {
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __('auth.js_error_title') }}',
                                    text: '{{ __('auth.js_network_error') }}',
                                    confirmButtonText: '{{ __('auth.js_ok_button') }}',
                                    confirmButtonColor: 'var(--sanad-color-primary, #6c5ce7)'
                                });
                            } else if (notice) {
                                notice.textContent = '{{ __('auth.js_network_error') }}';
                            }
                        } finally {
                            fresh.disabled = false;
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
