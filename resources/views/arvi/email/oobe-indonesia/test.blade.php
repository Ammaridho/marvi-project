<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Oobee.ai - {{ $merchant }}</title>
    <style>
            /*All the styling goes here*/
            img {
                border: none;
                -ms-interpolation-mode: bicubic;
                max-width: 100%;
            }
            body {
                background-color: #f6f6f6;
                font-family: sans-serif;
                -webkit-font-smoothing: antialiased;
                font-size: 14px;
                line-height: 1.4;
                margin: 0;
                padding: 0;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                color: #535353;
            }
            table {
                border-collapse: separate;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
                width: 100%; }
            table td {
                font-family: sans-serif;
                font-size: 14px;
                vertical-align: top;
            }

            /* -------------------------------------
                BODY & CONTAINER
            ------------------------------------- */

            .body {
                background-color: #f6f6f6;
                width: 100%;
            }

            /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
            .container {
                display: block;
                margin: 0 auto !important;
                /* makes it centered */
                max-width: 580px;
                padding: 10px;
                width: 580px;
            }

            /* This should also be a block element, so that it will fill 100% of the .container */
            .content {
                box-sizing: border-box;
                display: block;
                margin: 0 auto;
                max-width: 580px;
                padding: 10px;
            }

            /* -------------------------------------
                HEADER, FOOTER, MAIN
            ------------------------------------- */
            .main {
                background: #ffffff;
                border-radius: 3px;
                width: 100%;
            }
            .wrapper {
                box-sizing: border-box;
                padding: 20px;
            }
            .small{
                font-size: 12px;
            }
            .content-block {
                padding-bottom: 10px;
                padding-top: 10px;
            }
            .footer {
                clear: both;
                margin-top: 10px;
                text-align: center;
                width: 100%;
            }
            .footer td,
            .footer p,
            .footer span,
            .footer a {
                color: #999999;
                font-size: 12px;
                text-align: center;
            }

            /* -------------------------------------
                TYPOGRAPHY
            ------------------------------------- */
            h1, h2, h3, h4 {
                font-family: sans-serif;
                font-weight: 400;
                line-height: 1.4;
                margin: 0;
                margin-bottom: 30px;
                color: #999999;
            }
            h1 {
                font-size: 35px;
                font-weight: 300;
                text-transform: capitalize;
            }
            p, ul, ol {
                font-family: sans-serif;
                font-size: 14px;
                font-weight: normal;
                margin: 0;
                margin-bottom: 15px;
            }
            p li, ul li, ol li {
                list-style-position: inside;
                margin-left: 5px;
            }
            a {
                color: #3498db;
                text-decoration: underline;
            }

            /* -------------------------------------
                BUTTONS
            ------------------------------------- */
            .btn {
                box-sizing: border-box;
                width: 100%; }
            .btn > tbody > tr > td {
                padding-bottom: 15px; }
            .btn table {
                width: auto;
            }
            .btn table td {
                background-color: #ffffff;
                border-radius: 5px;
                text-align: center;
            }
            .btn a {
                background-color: #ffffff;
                border: solid 1px #3498db;
                border-radius: 5px;
                box-sizing: border-box;
                color: #3498db;
                cursor: pointer;
                display: inline-block;
                font-size: 14px;
                font-weight: bold;
                margin: 0;
                padding: 12px 25px;
                text-decoration: none;
                text-transform: capitalize;
            }

            .btn-primary table td {
                background-color: #3498db;
            }

            .btn-primary a {
                background-color: #3498db;
                border-color: #3498db;
                color: #ffffff;
            }

            /* -------------------------------------
                OTHER STYLES THAT MIGHT BE USEFUL
            ------------------------------------- */
            .last { margin-bottom: 0; }
            .first { margin-top: 0; }
            .align-center { text-align: center; }
            .align-right { text-align: right; }
            .align-left { text-align: left; }
            .clear { clear: both; }
            .mt0 { margin-top: 0; }
            .mb0 { margin-bottom: 0; }
            .preheader {
                color: transparent;
                display: none;
                height: 0;
                max-height: 0;
                max-width: 0;
                opacity: 0;
                overflow: hidden;
                mso-hide: all;
                visibility: hidden;
                width: 0;
            }

            .powered-by a {
                text-decoration: none;
            }

            hr {
                border: 0;
                border-bottom: 1px solid #f6f6f6;
                margin: 20px 0;
            }
            .gray{
                color: #999999;
            }
            .green{
                color: #4CA735;
            }
            .red{
                color: #FD5258;
            }
            .blue{
                color: #6795F4;
            }

            /* -------------------------------------
                RESPONSIVE AND MOBILE FRIENDLY STYLES
            ------------------------------------- */
            @media only screen and (max-width: 620px) {
                table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important;
                }
                table.body p,
                table.body ul,
                table.body ol,
                table.body td,
                table.body span,
                table.body a {
                    font-size: 16px !important;
                }
                table.body .wrapper,
                table.body .article {
                    padding: 10px !important;
                }
                table.body .content {
                    padding: 0 !important;
                }
                table.body .container {
                    padding: 0 !important;
                    width: 100% !important;
                }
                table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important;
                }
                table.body .btn table {
                    width: 100% !important;
                }
                table.body .btn a {
                    width: 100% !important;
                }
                table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important;
                }
            }

            /* -------------------------------------
                PRESERVE THESE STYLES IN THE HEAD
            ------------------------------------- */
            @media all {
                .ExternalClass {
                    width: 100%;
                }
                .ExternalClass,
                .ExternalClass p,
                .ExternalClass span,
                .ExternalClass font,
                .ExternalClass td,
                .ExternalClass div {
                    line-height: 100%;
                }
                .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important;
                }
                #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                }
                .btn-primary table td:hover {
                    background-color: #34495e !important;
                }
                .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important;
                }
            }

            .thumbnail-cart{
                width: 60px;
                height: 60px;
                flex: 0 0 auto;
                border-radius: 5px;
                background-size: cover;
                background-position: center center;
                background-repeat: no-repeat;
                border: 1px solid #eee;
            }
        </style>
</head>
<body>
<span class="preheader">Order Success - {{$orderNumber}}</span>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
    <tr>
        <td>&nbsp;</td>
        <td class="container">
            <div class="content">
                <br />
                <table role="presentation" class="main">
                    <tr>
                        <td class="wrapper">
                            <table role="presentation" border="0" cellpadding="4" cellspacing="0" class="table table-sm small">

                                <tr>
                                    <td colspan="2">
                                        <p>Hi {{$name}},</p>
                                            <p>
                                                Thank you for buying with us. Below is a summary of your recent purchase.
                                            </p>
                                        <p>
                                    </td>
                                </tr>

                                @php
                                    $i = 1;
                                @endphp

                                {{-- {{dd($products)}} --}}

                                @foreach ($products->reformJoinProductsOrder as $key => $item)
                                    @if ($item['product'])
                                    
                                        <tr class="border-top">
                                            <td class="font-weight-bold">
                                                {{$i++}}. {{$item['product']['product_name']}} 
                                                @if (isset($item['variant']))
                                                    ({{$item['variant']['variant_name']}})
                                                    @php
                                                        $price = $item['product']['product_price'] + 
                                                        $item['variant']['variant_price'];
                                                    @endphp
                                                @else
                                                    @php
                                                        $price = $item['product']['product_price'];
                                                    @endphp
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                {{$item['product']['product_currency']}}
                                                {{number_format($products->priceAll[$item['merchant_order_detail_id']]['price'])}}
                                            </td>
                                            <td class="text-center">{{$item['qty']}}</td>
                                            <td class="text-end">
                                                {{$item['product']['product_currency']}} 
                                                <span class="all-price selling_price" >
                                                {{number_format($products->priceAll[$item['merchant_order_detail_id']]['total_price'])}}
                                                </span>
                                            </td>
                                        </tr>

                                        @if (isset($item['attribute']))
                                            <tr>
                                                <td><small>Extra Condiments : </small></td>
                                            </tr>
                                            @foreach ($item['attribute'] as $attribute)
                                            <tr>
                                                <td>
                                                <small>- {{$attribute['attribute_name']}} 
                                                ({{$attribute['attribute_qty']}}x)</small>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        
                                        @if (isset($item['extra_attribute']))
                                            <tr>
                                                <td><small>Extra Cutlary : </small></td>
                                            </tr>
                                            @foreach ($item['extra_attribute'] as $extra_attribute)
                                                <tr>
                                                    <td>
                                                    <small>- {{$extra_attribute['extra_attribute_name']}} 
                                                        ({{$extra_attribute['extra_attribute_qty']}}x)</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                        @if (isset($item['remarks_product']))
                                            <tr>
                                                <td><small>Notes : </small></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <small>{{$item['remarks_product']}}</small>
                                                </td>
                                            </tr>
                                        @endif

                                    @endif

                                    @php
                                        $item = null;
                                    @endphp 
                                
                                @endforeach

                                {{-- <tr class="border-top">
                                    <td></td>
                                    <td></td>
                                    @if ($joinForOrderDetails['delivery_name'])
                                    <td class="text-end">{{$joinForOrderDetails['delivery_name']}}</td>
                                    <td class="text-end">{{$joinForOrderDetails->currency}} 
                                        <span class="all-price">
                                        {{number_format($joinForOrderDetails['cost_delivery'])}}
                                        </span>
                                    </td>
                                    @else
                                    <td class="text-end">Pick Up</td>
                                    <td class="text-end">FREE</td>
                                    @endif
                                </tr>

                                <tr class="border-top sum-all-product">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="fw-bold text-end">
                                        {{$joinForOrderDetails->currency}}
                                        {{}}
                                    </td>
                                </tr> --}}

                                <tr>
                                    <td colspan="2">
                                            <strong>Payment :</strong><br />
                                            {{$paymentMethod}}
                                        </p>
                                        <p>
                                            <strong>Buyer detail :</strong><br />
                                            Name : {{$name}} <br>
                                            Mobile {{$mobile_number}}<br>
                                            Email {{$email}}<br>
                                        </p>
                                        <br /><br />
                                        <p>Enjoy,</p>
                                    </td>
                                </tr>
                                        
                                
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="footer">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="content-block">
                                <span class="apple-link">All rights reserved. Copyright &copy; 2022 Oobe.ai.</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>
