<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:template match="/">
    <h2>Customers with All Membership Level</h2><br/>
    <table id="example" class="table table-hover" style="width:100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Total Spent</th>
          <th>Membership Level</th>
          <th>Discount</th>
        </tr>
      </thead>
      <tbody>
        <xsl:for-each select="customers/customer">
          <tr>
            <td><xsl:value-of select="name"/></td>
            <td><xsl:value-of select="email"/></td>
            <td><xsl:value-of select="phone"/></td>
            <td><xsl:value-of select="total-spent"/></td>
            <td><span class="{concat('membership-badge ', membership-level)}"><xsl:value-of select="membership-level"/></span></td>
            <td><xsl:value-of select="discount"/>%</td>
          </tr>
        </xsl:for-each>
      </tbody>
    </table>
  </xsl:template>
  
</xsl:stylesheet>
