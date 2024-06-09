<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:param name="level"/>

  <xsl:template match="/">
    <h2>Customers with Membership Level: <span class="membership-badge {$level}"><xsl:value-of select="$level"/></span></h2><br/>
    <table id="example" class="table table-hover" style="width:100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Total Spent</th>
          <th>Discount</th>
        </tr>
      </thead>
      <tbody>
        <xsl:for-each select="customers/customer[membership-level=$level]">
          <tr>
            <td><xsl:value-of select="name"/></td>
            <td><xsl:value-of select="email"/></td>
            <td><xsl:value-of select="phone"/></td>
            <td><xsl:value-of select="total-spent"/></td>
            <td><xsl:value-of select="discount"/>%</td>
          </tr>
        </xsl:for-each>
      </tbody>
    </table>
  </xsl:template>
  
</xsl:stylesheet>
