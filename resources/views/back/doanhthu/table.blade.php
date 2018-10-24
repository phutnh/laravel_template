<div class="table-responsive m-t-10" style="clear: both;" id="printAble">
   @if ($doanhthu)
    <table class="table table-striped table-bordered" id="data_doanhthu_table" data-check="ok">
      <thead>
        <tr>
          <td colspan="8">
            <address>
              <h3><b class="text-danger">Người in: {{ $doanhthu->nguoichot->tennhanvien }} #{{ $doanhthu->nguoichot->manhanvien }}</b></h3>
              <p class="text-muted">
                <b>Số doanh thu:</b> {{ $doanhthu->maso }}<br>
                <b>Ngày chốt:</b> {{ formatDateTimeData($doanhthu->ngaychot) }}<br>
                <b>Tổng tiền:</b> {{ formatMoneyData($doanhthu->sotien) }}<br>
                <b>Số lần in:</b> {{ formatMoneyData($doanhthu->solanin) }}
              </p>
           </address>
          </td>
        </tr>
        <tr>
          <td colspan="8" class="nowrap text-center">
            <b>Bảng chi tiết chốt doanh thu</b>
          </td>
        </tr>
         <tr>
            <th class="nowrap">#</th>
            <th class="nowrap">Mã nhân viên</th>
            <th class="nowrap">Tên nhân viên</th>
            <th class="nowrap">Số tài khoản</th>
            <th class="nowrap">Tên ngân hàng</th>
            <th class="nowrap">Chi nhánh</th>
            <th class="nowrap">Số điện thoại liên hệ</th>
            <th class="nowrap" class="text-right">Số tiền</th>
         </tr>
      </thead>
      <tbody>
        @php
        $tongtien = 0;
        @endphp
      @foreach ($doanhthu->chitietdoanhthu as $chitietdoanhthu)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $chitietdoanhthu->nhanvien->manhanvien }}</td>
          <td>{{ $chitietdoanhthu->nhanvien->tennhanvien }}</td>
          <td>{{ $chitietdoanhthu->nhanvien->sotaikhoan }}</td>
          <td>{{ $chitietdoanhthu->nhanvien->tennganhang }}</td>
          <td>{{ $chitietdoanhthu->nhanvien->chinhanh }}</td>
          <td>{{ $chitietdoanhthu->nhanvien->sodidong }}</td>
          <td>{{ formatMoneyData($chitietdoanhthu->sotien) }}</td>
        @php
        $tongtien += $chitietdoanhthu->sotien;
        @endphp
        </tr>
      @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="7"><b>Tổng tiền</b></td>
          <td>{{  formatMoneyData($tongtien) }}</td>
        </tr>
      </tfoot>
   </table>
   @else
    <h4><b>Không tìm thấy dữ liệu chốt doanh thu</b></h4>
   @endif
   
</div>