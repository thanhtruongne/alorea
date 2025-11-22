import { Typography } from 'antd';

const { Title, Text, Paragraph } = Typography;
const HuongDanThanhToan = () => (
   <div className='min-h-screen bg-gray-50'>
      <div className="bg-gradient-to-br from-burgundy-primary to-burgundy-dark">
        <div className="relative overflow-hidden">
          <div className="absolute inset-0 bg-black/20"></div>
          <div className="relative px-4 py-10 sm:py-14 lg:py-20 mt-10">
            <div className="max-w-4xl mx-auto text-center">
              <Title level={1} className="!text-white !text-2xl sm:!text-4xl lg:!text-5xl !font-serif !mb-4">HƯỚNG DẪN THANH TOÁN</Title>
              <div className="w-16 sm:w-24 h-1 bg-white mx-auto mb-4 sm:mb-6"></div>
            </div>
          </div>
        </div>
      </div>
      <div className="px-4 sm:px-6 lg:px-8 py-8">
        <div className="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-4 sm:p-8 text-base sm:text-lg">
          <Title level={2} className="!mb-4 !text-burgundy-primary">Chúng tôi hỗ trợ các phương thức thanh toán sau:</Title>
          <Paragraph>
            <Text strong>1. Thanh toán khi nhận hàng (COD):</Text> Thanh toán trực tiếp cho nhân viên giao hàng.
          </Paragraph>
          <Paragraph>
            <Text strong>2. Chuyển khoản ngân hàng:</Text><br/>
            Ngân hàng ACB<br/>
            Số tài khoản: <Text code>682228998</Text><br/>
                Chủ tài khoản: CTY TNHH TM DV ALORÉA<br/>
                        <Text type="warning">Lưu ý: Quý khách vui lòng ghi rõ mã đơn hàng khi chuyển khoản. Nếu có bất kỳ vấn đề nào cần hỗ trợ, vui lòng liên hệ ngay với chúng tôi qua Hotline/Zalo: <Text code>0911.468.678</Text></Text>
                </Paragraph>
          <Paragraph>
            <Text strong>3. Thanh toán trực tiếp tại cửa hàng:</Text><br/>
            Giờ làm việc: 08h00 – 17h00 (Thứ 2 – Thứ 7)<br/>
            Địa chỉ: Số 65 Đường số 4, Khu dân cư CityLand, Phường An Nhơn, Thành phố Hồ Chí Minh, Việt Nam
          </Paragraph>
        </div>
      </div>
   </div>
);
export default HuongDanThanhToan;
