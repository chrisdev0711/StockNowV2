<!-- Inliner Build Version 4380b7741bb759d6cb997545f3add21ad48f010b -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-size: 100%; font-family: 'Avenir Next', 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; line-height: 1.65; margin: 0; padding: 0;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- For development, pass document through inliner -->
</head>
<body style="font-size: 100%; font-family: 'Avenir Next', 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; line-height: 1.65; width: 100% !important; height: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; background: #efefef; margin: 0; padding: 0; color: #000 !important;" bgcolor="#efefef">
    <h1 style="margin-top: 50px; text-align: center; font-size: 40px; margin-bottom: 30px;">Purchase Order {{$details['order_id']}}</h1>
    <div style="max-width: 1360px; margin-left: auto; margin-right: auto;">
        <div style="display: inline-block; width: 10%;"></div>
        <div style="display: inline-block; width: 39%;">
            <div style="margin: auto; width: 300px;">
                <h5 style="font-size: 1.25rem; font-weight: 500; margin-bottom: 0.5rem; line-height: 1.2; margin-top: 0;">TO: </h5>
                <h6 style="font-size: 1rem; margin-bottom: 0.5rem; font-weight: 500; line-height: 1.2; margin-top: 0;">{{$details['supplier']}}</h6>
                <h6 style="font-size: 1rem; margin-bottom: 0.5rem; font-weight: 500; line-height: 1.2; margin-top: 0;">{{$details['supplier_address']}}</h6>
                <h6 style="font-size: 1rem; margin-bottom: 0.5rem; font-weight: 500; line-height: 1.2; margin-top: 0;">{{$details['supplier_city']}}</h6>
                <h6 style="font-size: 1rem; margin-bottom: 0.5rem; font-weight: 500; line-height: 1.2; margin-top: 0;">{{$details['supplier_county']}}</h6>
                <h6 style="font-size: 1rem; margin-bottom: 0.5rem; font-weight: 500; line-height: 1.2; margin-top: 0;">{{$details['supplier_postcode']}}</h6>
            </div>
        </div>
        <div style="display: inline-block; width: 39%;">
            <div style="margin: auto; width: 300px;">
                <h5 style="font-size: 1.25rem; font-weight: 500; margin-bottom: 0.5rem; line-height: 1.2; margin-top: 0;">SHIP TO: </h5>
                <h6 style="font-size: 1rem; margin-bottom: 0.5rem; font-weight: 500; line-height: 1.2; margin-top: 0;">{{$details['site_name']}}</h6>
                <h6 style="font-size: 1rem; margin-bottom: 0.5rem; font-weight: 500; line-height: 1.2; margin-top: 0;">{{$details['site_addresss']}}</h6>
                <h6 style="font-size: 1rem; margin-bottom: 0.5rem; font-weight: 500; line-height: 1.2; margin-top: 0;">{{$details['site_city']}}</h6>
                <h6 style="font-size: 1rem; margin-bottom: 0.5rem; font-weight: 500; line-height: 1.2; margin-top: 0;">{{$details['site_postcode']}}</h6>
            </div>
        </div>
        <div style="display: inline-block; width: 10%;"></div>

        <div style="margin: auto; width: 90%;">
            <table style="width: 100%; margin-bottom: 1rem; color: #212529; border: 1px solid black !important; margin-top: 40px; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">P.O DATE</th>
                        <th style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">REQUISITIONER</th>
                        <th style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">DELIVERY DATE</th>
                        <th style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">F.O.B. POINT</th>
                        <th style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">TERMS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top; text-align: center;">{{$details['order_date']}}</td>
                        <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top; text-align: center;">{{ Auth::user()->name }}</td>
                        <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top; text-align: center;">{{$details['delivery_date']}}</td>
                        <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top; text-align: center;">ON DELIVERY</td>
                        <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top; text-align: center;">{{$details['term']}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin: auto; width: 90%">
            <table style="width: 100%; margin-bottom: 1rem; color: #212529; border: 1px solid black !important; margin-top: 40px; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">QTY</th>
                        <th style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">SKU</th>
                        <th style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">DESCRIPTION</th>
                        <th style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">UNIT PRICE</th>
                        <th style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top; text-align: center;">{{$details['qty']}}</td>
                        <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top; text-align: center;">{{$details['sku']}}</td>
                        <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top; text-align: center;">{{$details['description']}}</td>
                        <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top; text-align: center;">£ {{$details['unit_price']}}</td>
                        <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top; text-align: center;">£ {{$details['total']}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- <div style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;"> -->
        <div>
            <div style="display: inline-block; width: 10%;"></div>
            <div style="display: inline-block; width: 39%; vertical-align: top; margin-top: 50px;">
                <div style="margin: auto; width: 300px;">
                    <h6 style="font-size: 1rem; margin-bottom: 0.5rem; font-weight: 500; line-height: 1.2; margin-top: 0;">NOTES:</h6>
                    @isset($details['note'])
                        {{$details['note']}}
                    @endisset
                    @empty($details['note'])
                        <h6 style="font-size: 1rem; margin-bottom: 0.5rem; font-weight: 500; line-height: 1.2; margin-top: 0;">There are no notes for this order</h6>
                    @endempty
                </div>
            </div>
            <div style="display: inline-block; width: 45.7%; vertical-align: middle;">
                    <table style="width: 100%; margin-bottom: 1rem; color: #212529; border: 1px solid black !important; margin-top: 40px; border-collapse: collapse; text-align: right;">
                        <tbody>
                            <tr>
                                <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top;"><b>SUBTOTAL</b></td>
                                <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">£ {{$details['total']}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top;"><b>VAT</b></td>
                                <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">£ {{$details['vat']}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top;"><b>TOTAL</b></td>
                                <td style="border: 1px solid black !important; padding: .75rem; vertical-align: top;">£ {{$details['total'] + $details['vat']}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>