import { Typography } from 'antd';

const { Title, Paragraph, Text } = Typography;
const DieuKhoanChung = () => (
  <div className="min-h-screen bg-gray-50">
    <div className="bg-gradient-to-br from-burgundy-primary to-burgundy-dark">
      <div className="relative overflow-hidden">
        <div className="absolute inset-0 bg-black/20"></div>
        <div className="relative px-4 py-10 sm:py-14 lg:py-20 mt-10">
          <div className="max-w-4xl mx-auto text-center">
            <Title level={1} className="!text-white !text-2xl sm:!text-4xl lg:!text-5xl !font-serif !mb-4">ĐIỀU KHOẢN CHUNG</Title>
            <div className="w-16 sm:w-24 h-1 bg-white mx-auto mb-4 sm:mb-6"></div>
          </div>
        </div>
      </div>
    </div>
    <div className="px-4 sm:px-6 lg:px-8 py-8">
      <div className="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-4 sm:p-8 text-base sm:text-lg">
        <Paragraph><Text strong>Chất lượng sản phẩm:</Text> CTY TNHH TM DV ALORÉA cam kết cung cấp sản phẩm đạt tiêu chuẩn cao, được sản xuất và đóng gói theo quy trình kiểm soát nghiêm ngặt.</Paragraph>
        <Paragraph><Text strong>Thanh toán:</Text> Quý khách có thể thanh toán khi nhận hàng (COD) hoặc chuyển khoản theo thông tin cung cấp trong quá trình đặt hàng.</Paragraph>
        <Paragraph><Text strong>Vận chuyển:</Text> Chúng tôi hỗ trợ giao hàng trên toàn quốc với thời gian nhanh nhất có thể với mức phí hợp lý.</Paragraph>
        <Paragraph><Text strong>Chính sách đổi trả:</Text> Sản phẩm có thể được đổi/trả nếu có lỗi từ phía chúng tôi hoặc theo các điều kiện cụ thể được quy định trong chính sách đổi trả và bảo hành.</Paragraph>
        <Paragraph><Text strong>Bảo mật thông tin:</Text> Chúng tôi cam kết bảo vệ thông tin cá nhân của khách hàng và không chia sẻ với bên thứ ba không liên quan.</Paragraph>
        <Paragraph><Text strong>Quy định pháp lý:</Text> Khi sử dụng website hoặc dịch vụ của chúng tôi, quý khách đồng ý với Chính sách Bảo mật và Điều khoản Sử dụng.</Paragraph>
        <Paragraph><Text strong>Sở hữu trí tuệ:</Text> Tất cả nội dung trên website thuộc quyền sở hữu của chúng tôi và được bảo vệ theo luật sở hữu trí tuệ. Nghiêm cấm sao chép, sử dụng mà không có sự đồng ý bằng văn bản.</Paragraph>
        <Paragraph><Text strong>Giới hạn trách nhiệm:</Text> Chúng tôi không chịu trách nhiệm đối với các thiệt hại phát sinh từ việc sử dụng sản phẩm không đúng hướng dẫn hoặc do lỗi từ bên thứ ba.</Paragraph>
        <Paragraph><Text strong>Thay đổi điều khoản:</Text> Chúng tôi có quyền thay đổi nội dung chính sách mà không cần thông báo trước. Quý khách vui lòng kiểm tra thường xuyên để cập nhật thông tin.</Paragraph>
        <Paragraph><Text strong>Liên hệ hỗ trợ:</Text> Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ qua thông tin trên website hoặc Hotline/Zalo: <Text code>0911.468.678</Text> để được hỗ trợ.</Paragraph>
      </div>
    </div>
  </div>
);
export default DieuKhoanChung;
