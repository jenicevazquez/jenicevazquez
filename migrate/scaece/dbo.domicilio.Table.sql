/****** Object:  Table [dbo].[domicilio]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[domicilio](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[calle] [varchar](80) NULL,
	[exterior] [varchar](10) NULL,
	[interior] [varchar](10) NULL,
	[ciudad] [varchar](80) NULL,
	[cp] [varchar](10) NULL,
	[pais] [varchar](250) NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_domicilio] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
