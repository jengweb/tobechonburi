<div class="main_content">
	<div class="colum-admin">
		<script type="text/javascript">
            function ActiveField(Fieldname) {
               document.getElementById(Fieldname).style.background = '#FEF1C1';
            }
            function InactiveField(Fieldname) {
              document.getElementById(Fieldname).style.background ='#FFF'
            }
        </script>
		<form action="/admin/calendars_manage/" method="post">
			<div class='Form-div'>
				<div class='title-insert'>
					<div>
						เพิ่มปฏิทิน
						<hr />
					</div>
				</div>
				<!-- Date -->
				<div id="dateBG" style="">
					<label>วันจัดกิจกรรม</label><br>
					<input type="date" name="event_date" onclick="ActiveField('dateBG');" onblur="InactiveField('dateBG');">
				</div>
				<!-- Note -->
				<div id="detailBG">
					<label> รายละเอียดกิจกรรม</label><br>
					<textarea name="event_detail" rows="4" cols="50" onclick="ActiveField('detailBG');" onblur="InactiveField('detailBG');"> </textarea>
				</div>
				<div style="margin-top: 10px;">
					<!--Button submit-->
					<input type="submit" id="btn-insert" class="btn-insert" onclick="this.style.display='none'; btn-reset.style.display='none';" value="บันทึก" />

					<!--Button reset-->
					<input type="reset" id="btn-reset" class="btn-reset" onclick="var link = window.location.href.split('#'); customWindowOpen(link[0],'_self'); return false;" value='Reset' style="background-color: #20B2AA; padding: 3px 10px" />
				</div>
			</div>
		</form>
	</div>
	<div class="clear"></div>
</div>