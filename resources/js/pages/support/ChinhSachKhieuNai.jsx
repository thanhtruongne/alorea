import { Typography } from 'antd';

const { Title, Paragraph, Text } = Typography;
const ChinhSachKhieuNai = () => (
  <div className="min-h-screen bg-gray-50">
    <div className="bg-gradient-to-br from-burgundy-primary to-burgundy-dark">
      <div className="relative overflow-hidden">
        <div className="absolute inset-0 bg-black/20"></div>
        <div className="relative px-4 py-10 sm:py-14 lg:py-20 mt-10">
          <div className="max-w-4xl mx-auto text-center">
            <Title level={1} className="!text-white !text-2xl sm:!text-4xl lg:!text-5xl !font-serif !mb-4">Chính sách khiếu nại & kiểm tra sản phẩm</Title>
            <div className="w-16 sm:w-24 h-1 bg-white mx-auto mb-4 sm:mb-6"></div>
          </div>
        </div>
      </div>
    </div>
    <div className="px-4 sm:px-6 lg:px-8 py-8">
      <div className="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-4 sm:p-8 text-base sm:text-lg">
        <Paragraph><Text strong>Khách hàng kiểm tra cùng người giao hàng (shipper):</Text> Khách hàng kiểm tra cùng người giao hàng để đảm bảo rằng sản phẩm đúng loại và đúng số lượng.</Paragraph>
        <Paragraph><Text strong>Xác nhận sản phẩm:</Text> Khách hàng có thể mở kiện hàng, xác minh rằng sản phẩm đúng loại và chất lượng như đã đặt hàng.</Paragraph>
        <Paragraph><Text strong>Kiểm tra số lượng:</Text> Kiểm tra số lượng sản phẩm có đúng với đơn hàng mua hàng hay không.</Paragraph>
        <Paragraph><Text strong>Kiểm tra trạng thái sản phẩm:</Text> Đảm bảo sản phẩm không bị hỏng hóc hoặc có bất kỳ vấn đề nào khác.</Paragraph>
        <Paragraph><Text strong>Số hotline hỗ trợ:</Text> Số hotline hỗ trợ của CTY TNHH TM DV ALORÉA là <Text code>0911.468.678</Text>. Bạn có thể gọi điện hoặc nhắn tin để yêu cầu thông tin chi tiết về quy trình kiểm tra sản phẩm cùng người giao hàng, cũng như bất kỳ thông tin hỗ trợ nào khác liên quan đến sản phẩm. Nhân viên chăm sóc khách hàng sẽ giúp bạn hiểu rõ hơn về quy trình kiểm tra sản phẩm khi nhận hàng và cung cấp mọi thông tin cần thiết để đảm bảo bạn có trải nghiệm mua sắm tốt nhất cùng CTY TNHH TM DV ALORÉA.</Paragraph>
      </div>
    </div>
  </div>
);
export default ChinhSachKhieuNai;
