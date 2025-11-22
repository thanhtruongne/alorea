import { Typography } from 'antd';

const { Title, Text, Paragraph } = Typography;
const HuongDanMuaHang = () => (
   <div className="min-h-screen bg-gray-50">
      <div className="bg-gradient-to-br from-burgundy-primary to-burgundy-dark">
        <div className="relative overflow-hidden">
          <div className="absolute inset-0 bg-black/20"></div>
          <div className="relative px-4 py-10 sm:py-14 lg:py-20 mt-10">
            <div className="max-w-4xl mx-auto text-center">
              <Title level={1} className="!text-white !text-2xl sm:!text-4xl lg:!text-5xl !font-serif !mb-4">HƯỚNG DẪN MUA HÀNG</Title>
              <div className="w-16 sm:w-24 h-1 bg-white mx-auto mb-4 sm:mb-6"></div>
            </div>
          </div>
        </div>
      </div>
      <div className="px-4 sm:px-6 lg:px-8 py-8">
        <div className="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-4 sm:p-8 text-base sm:text-lg">
          <Title level={2} className="!mb-4 !text-burgundy-primary">Để mua sản phẩm trên trang web bạn có thể làm theo các bước sau:</Title>
          <Title level={3} className="!mt-6 !mb-2">Mua trên trang web:</Title>
          <Paragraph>
            <Text strong>Truy cập trang web của CTY TNHH TM DV ALORÉA</Text><br/>
            Mở trình duyệt web và nhập địa chỉ trang web của CTY TNHH TM DV ALORÉA: <Text code>store.alorea.com</Text>
          </Paragraph>
          <Paragraph>
            <Text strong>Tìm sản phẩm:</Text><br/>
            Tại trang chủ hoặc mục sản phẩm, tìm kiếm hoặc chọn mục sản phẩm mà bạn cần mua.
          </Paragraph>
          <Paragraph>
            <Text strong>Thêm vào giỏ hàng và thanh toán:</Text><br/>
            Chọn sản phẩm và thêm vào giỏ hàng.<br/>
            Tiếp theo, bạn sẽ được yêu cầu điền thông tin cá nhân và địa chỉ giao hàng.<br/>
            Chọn phương thức thanh toán phù hợp (COD hoặc chuyển khoản) và hoàn tất thanh toán.<br/>
            Kiểm tra lại thông tin, nhấn “Đặt hàng” để hoàn tất.
          </Paragraph>
          <Title level={3} className="!mt-8 !mb-2">Liên hệ trực tiếp qua hotline/Zalo:</Title>
          <Paragraph>
            <Text strong>Gọi hoặc nhắn tin qua Hotline/Zalo:</Text><br/>
            Gọi số hotline của CTY TNHH TM DV ALORÉA: <Text code>0911.468.678</Text> hoặc nhắn tin qua Zalo theo số này.
          </Paragraph>
          <Paragraph>
            <Text strong>Yêu cầu mua sản phẩm:</Text><br/>
            Liên hệ với nhân viên tư vấn để đặt mua sản phẩm.<br/>
            Cung cấp thông tin cá nhân cần thiết và địa chỉ giao hàng.
          </Paragraph>
          <Paragraph>
            <Text strong>Thanh toán và xác nhận đơn hàng:</Text><br/>
            Nhân viên sẽ hỗ trợ bạn về việc thanh toán theo phương thức bạn chọn và xác nhận đơn hàng của bạn.
          </Paragraph>
          <Paragraph type="warning">
            <Text strong>Lưu ý:</Text> Trước khi mua hàng, hãy xác nhận thông tin đầy đủ về sản phẩm, giá cả và chính sách vận chuyển, đảm bảo bạn đã hiểu rõ về quy trình và điều kiện mua hàng từ CTY TNHH TM DV ALORÉA.
          </Paragraph>
        </div>
      </div>
   </div>
);
export default HuongDanMuaHang;
