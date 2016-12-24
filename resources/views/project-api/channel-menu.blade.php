						<div class="radius-4 ct-nav">
							<table class="ct-nav-table">
								<tr>
									<td class="ct-nav-left">
										<b>　API 调试　　/channel-menu</b>
									</td>
									<td class="ct-nav-right">
									</td>
								</tr>
							</table>
						</div>

						<div class="content-body radius-5 content-border" style="padding:20px;">
							<table class="notes-table">
    							<tbody>
                                    <tr>
										<td style="width:80px;">接　　口：</td>
										<td colspan="2">客户端通过此接口获取频道列表 </td>
									</tr>
                                    <tr>
										<td>请求地址：</td>
										<td style="width:80px;"><b>/channel-menu</b></td>
										<td></td>
									</tr>
                                    <tr>
										<td>请求方法：</td>
										<td>GET</td>
										<td></td>
									</tr>
                                    <tr>
										<td>请求参数：</td>
										<td><b>null</b></td>
										<td></td>
									</tr>
                                    <tr>
										<td>发送头：<br>Authorization</td>
										<td colspan="2" >
											<textarea style="height:80px;width:800px;" class="text-input">{{ $authorization }}</textarea>
										</td>
									</tr>
                                    <tr>
										<td>返回说明：</td>
										<td colspan="2">
<textarea wrap="off" style="height:300px;width:800px;overflow:scroll;" class="text-input">{
  [channel_menu] => {
    [0] => {
      [id] => 1435523,
      [name] => '西直门'
    }
    [1] => {
      [id] => 1212,
      [name] => '大兴'
    }
    [2] => {
      [id] => 51263,
      [name] => '北京'
    }
    [3] => {
      [id] => 12315,
      [name] => '北京郊区'
    }
    [4] => {
      [id] => 54612,
      [name] => '赛百味'
    }
  }
}</textarea></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="content-body radius-5 content-border" style="padding:20px;">
							<table class="notes-table">
    							<tbody>
    								<tr>
    									<td style="width:610px;">
											<div style="width:600px;position:relative;">
												<dl><dd>
												<input class="text-input" value="API 请求地址：  http://{{ $_SERVER["HTTP_HOST"] }}/channel-menu" readonly="true" type="text">
												</dd></dl>
											</div>
    									</td>
										<td style="width:80px;">
											<a href="/channel-menu" header='{ "Authorization": "{{ urlencode($authorization) }}" }' pushstate="no" container="#debug-response-container">
											<button type="button" class="button-btn" style="width:70px;">测试接口</button>
											</a>
										</td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>