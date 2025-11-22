import { Typography } from 'antd';

const { Title, Paragraph, Text } = Typography;
const ChinhSachVanChuyen = () => (
  <div className="min-h-screen bg-gray-50">
    <div className="bg-gradient-to-br from-burgundy-primary to-burgundy-dark">
      <div className="relative overflow-hidden">
        <div className="absolute inset-0 bg-black/20"></div>
        <div className="relative px-4 py-10 sm:py-14 lg:py-20 mt-10">
          <div className="max-w-4xl mx-auto text-center">
            <Title level={1} className="!text-white !text-2xl sm:!text-4xl lg:!text-5xl !font-serif !mb-4">Chính sách vận chuyển</Title>
            <div className="w-16 sm:w-24 h-1 bg-white mx-auto mb-4 sm:mb-6"></div>
          </div>
        </div>
      </div>
    </div>
    <div className="px-4 sm:px-6 lg:px-8 py-8">
      <div className="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-4 sm:p-8 text-base sm:text-lg">
        <Title level={3} className="!mt-6">Các phương thức giao hàng</Title>
        <Paragraph>
          Chúng tôi sử dụng 02 phương thức giao hàng:
          <ul className="list-disc ml-6 mt-2">
            <li>Khách hàng mua trực tiếp hàng tại cửa hàng của chúng tôi</li>
            <li>Ship hàng</li>
          </ul>
        </Paragraph>
        <Title level={3} className="!mt-6">Thời hạn ước tính cho việc giao hàng</Title>
        <Paragraph>
          Thời gian nhận hàng: tùy thuộc vào loại hình dịch vụ/hình thức gửi hàng, Bên cung cấp dịch vụ sẽ thông báo cụ thể về thời gian nhận hàng của khách hàng sau khi khách hàng xác nhận đơn hàng.<br/>
          Hình thức chuyển hàng: Nhân viên giao hàng đến địa chỉ khách hàng cung cấp.<br/>
          Trước khi chuyển hàng, Bên cung cấp dịch vụ sẽ thông báo cho khách hàng về thời gian và cước phí giao hàng (nếu có).<br/>
          Trường hợp phát sinh chậm trễ trong việc giao hàng không phải do lỗi của Bên cung cấp dịch vụ thì Bên cung cấp dịch vụ sẽ có thông tin kịp thời cho khách hàng và khách hàng có thể hủy giao dịch (nếu muốn).
          <ul className="list-disc ml-6 mt-2">
            <li>Nhân viên chúng tôi liên lạc với khách hàng qua điện thoại không được nên không thể giao hàng.</li>
            <li>Địa chỉ giao hàng bạn cung cấp không chính xác hoặc khó tìm.</li>
            <li>Số lượng đơn hàng tăng đột biến khiến việc xử lý đơn hàng bị chậm.</li>
            <li>Đối tác cung cấp hàng chậm hơn dự kiến khiến việc giao hàng bị chậm lại hoặc đối tác vận chuyển giao hàng bị chậm.</li>
          </ul>
          Về phí vận chuyển, chúng tôi sử dụng dịch vụ vận chuyển ngoài nên cước phí vận chuyển sẽ được tính theo phí của các đơn vị vận chuyển tùy vào vị trí và khối lượng của đơn hàng, khi liên hệ lại xác nhận đơn hàng với khách sẽ báo mức phí cụ thể cho khách hàng.
        </Paragraph>
        <Title level={3} className="!mt-6">Các giới hạn về mặt địa lý cho việc giao hàng</Title>
        <Paragraph>
          Do tính chất sản phẩm tươi không chất bảo quản nên chỉ giới hạn giao hàng ở khu vực Thành phố Hồ Chi Minh, Bình Dương.<br/>
          Riêng khách tỉnh có nhu cầu mua số lượng lớn hoặc khách buôn sỉ nếu có nhu cầu mua sản phẩm, chúng tôi sẽ nhờ dịch vụ giao nhận của các công ty vận chuyển và phí sẽ được tính theo phí của các đơn vị cung cấp dịch vụ vận chuyển hoặc theo thoả thuận hợp đồng giữa 2 bên.
        </Paragraph>
        <Title level={3} className="!mt-6">Phân định trách nhiệm về chứng từ hàng hóa trong quá trình giao nhận</Title>
        <Paragraph>
          Bên vận chuyển có trách nhiệm cung cấp chứng từ hàng hóa khi giao hàng từ bên thuê vận chuyển.<br/>
          Tất cả các đơn hàng đều được đóng gói sẵn sàng trước khi vận chuyển, được niêm phong bởi sugartown.store.<br/>
          Đơn vị vận chuyển sẽ chỉ chịu trách nhiệm vận chuyển hàng hóa theo nguyên tắc “nguyên đai, nguyên kiện”.<br/>
          Bên sugartown.store là bên cung cấp hóa đơn bán hàng khi giao hàng cho người mua.<br/>
          Trên bao bì tất cả các đơn hàng đều có thông tin:
          <ul className="list-disc ml-6 mt-2">
            <li>Thông tin Người nhận, bao gồm: Tên người nhận, số điện thoại và địa chỉ người nhận</li>
            <li>Mã vận đơn của đơn hàng</li>
          </ul>
          Để đảm bảo an toàn cho hàng hóa, sugartown.store sẽ gửi kèm hóa đơn tài chính hoặc phiếu xuất kho hợp lệ của sản phẩm trong bưu kiện (nếu có).<br/>
          Hóa đơn tài chính hoặc phiếu xuất kho là căn cứ hỗ trợ quá trình xử lý khiếu nại như: xác định giá trị thị trường của hàng hóa, đảm bảo hàng hóa lưu thông hợp lệ v.v..
        </Paragraph>
        <Title level={3} className="!mt-6">Trách nhiệm của bên vận chuyển và bên thuê vận chuyển</Title>
        <Paragraph>
          <ul className="list-disc ml-6 mt-2">
            <li>Bảo đảm vận chuyển tài sản đầy đủ, an toàn đến địa điểm đã định, theo đúng thời hạn.</li>
            <li>Giao tài sản cho người có quyền nhận.</li>
            <li>Chịu chi phí liên quan đến việc chuyên chở tài sản, trừ trường hợp có thỏa thuận khác.</li>
            <li>Mua bảo hiểm trách nhiệm dân sự theo quy định của pháp luật.</li>
            <li>Bồi thường thiệt hại cho bên thuê vận chuyển trong trường hợp bên vận chuyển để mất, hư hỏng tài sản, trừ trường hợp có thỏa thuận khác hoặc pháp luật có quy định khác.</li>
            <li>Kiểm tra sự xác thực của tài sản, của vận đơn hoặc chứng từ vận chuyển tương đương khác.</li>
            <li>Từ chối vận chuyển tài sản không đúng với loại tài sản đã thỏa thuận trong hợp đồng.</li>
            <li>Yêu cầu bên thuê vận chuyển thanh toán đủ cước phí vận chuyển đúng thời hạn.</li>
            <li>Từ chối vận chuyển tài sản cấm giao dịch, tài sản có tính chất nguy hiểm, độc hại, nếu bên vận chuyển biết hoặc phải biết.</li>
            <li>Trả đủ tiền cước phí vận chuyển cho bên vận chuyển theo đúng thời hạn, phương thức đã thỏa thuận.</li>
            <li>Cung cấp thông tin cần thiết liên quan đến tài sản vận chuyển để bảo đảm an toàn cho tài sản vận chuyển.</li>
            <li>Trông coi tài sản trên đường vận chuyển, nếu có thỏa thuận. Trường hợp bên thuê vận chuyển trông coi tài sản mà tài sản bị mất, hư hỏng thì không được bồi thường.</li>
            <li>Yêu cầu bên vận chuyển chuyên chở tài sản đến đúng địa điểm, thời điểm đã thỏa thuận.</li>
            <li>Trực tiếp hoặc chỉ định người thứ ba nhận lại tài sản đã thuê vận chuyển.</li>
          </ul>
        </Paragraph>
        <Title level={3} className="!mt-6">Trách nhiệm về trường hợp hàng bị hư hỏng do quá trình vận chuyển</Title>
        <Paragraph>
          Đối với hàng hóa bị hư hỏng do quá trình vận chuyển dù là đơn hàng do chính cửa hàng vận chuyển hay do bên thứ 3 vận chuyển thì chúng tôi sẽ là bên đứng ra chịu trách nhiệm giải quyết vấn đề cho khách hàng.<br/>
          Khách hàng có quyền từ chối nhận sản phẩm và yêu cầu đổi trả theo quy định “đổi trả hoàn phí” còn mọi vấn đề phát sinh chúng tôi sẽ làm việc lại với đối tác vận chuyển để giải quyết đền bù cho đơn hàng theo thỏa thuận hợp tác giữa công ty với đối tác thứ 3 cung cấp dịch vụ vận chuyển.<br/>
          <Text type="warning">Lưu ý: Trường hợp phát sinh chậm trễ trong việc giao hàng chúng tôi sẽ thông tin kịp thời cho khách hàng và khách hàng có thể lựa chọn giữa việc Hủy hoặc tiếp tục chờ hàng.</Text>
        </Paragraph>
      </div>
    </div>
  </div>
);
export default ChinhSachVanChuyen;
