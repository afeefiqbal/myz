@php
    use App\Models\Product;
@endphp
<table id="recordsReport" class="table table-bordered table-hover">
    <tbody>
        <tr>
            <th># <input type="checkbox" class="mt-2 ml-3" name="check_all" id="check_all">
            </th>
            <th colspan="3">Name</th>
            @if($type == "bulk")
                <th colspan="4">Product</th>
                <th colspan="4">Type</th>
                <th colspan="4">Frame</th>
                <th colspan="4">Mount</th>
                <th colspan="4">Size</th>
            @endif
            <th colspan="3">Email</th>
            <th colspan="3">Phone Number</th>
     
            <th colspan="6">Message</th>
            <th colspan="6">Reply</th>
            <th colspan="6">Request URL</th>
            <th colspan="6">Created Date</th>
          
        </tr>
    @php 
    $i=1 
    @endphp
        @foreach($enquiryList as $enquiry)
                                        <tr>
                                            <td>{{ $loop->iteration }}
                                            
                                            <td colspan="3">{{ $enquiry['name']}}</td>
                                            @if($type == "bulk")
                                                <td  colspan="4">{{ $enquiry['product'] ?? ''}}</td>
                                                <td  colspan="4">{{ $enquiry['type'] ?? ''}}</td>
                                                <td  colspan="4">{{ $enquiry['frame'] ?? ''}}</td>
                                           
                                                <td  colspan="4">
                                                   {{ $enquiry['mount']}}
                                            </td>
                                                <td  colspan="4">{{ $enquiry['size']  ?? ''}}</td>
                                            @endif
                                            <td  colspan="3">{{ $enquiry['email']}}</td>
                                            <td  colspan="3">{{ $enquiry['phone'] }}</td>
                                        
                                            <td  colspan="6">{{ $enquiry['message'] }}</td>
                                            <td  colspan="6">{{ $enquiry['reply'] }}</td>
                                            <td  colspan="6">{{ $enquiry['request_url'] }}</td>
                                            <td  colspan="6">{{  $enquiry['created_at'] }}</td>
                                          
                                        </tr>
                                    @endforeach
    </tbody>
</table>
