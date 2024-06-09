<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <table id="example" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Delivery Date</th>
                <th>Delivery Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <xsl:for-each select="delivery/car">
                <tr>
                    <td><xsl:value-of select="payment_id"/></td>
                    <td><xsl:value-of select="delivery_date"/></td>
                    <td><xsl:value-of select="delivery_status"/></td>
                    <td> 
                        <a href="{concat('/admin/delivery/', payment_id)}" class="btn btn-success btn-edit" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
                    </td>
                </tr>
            </xsl:for-each>
        </tbody>
    </table>
  </xsl:template>
</xsl:stylesheet>
