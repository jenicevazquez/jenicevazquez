/****** Object:  Table [dbo].[transportes]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[transportes](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[identificacion] [varchar](50) NULL,
	[pais] [varchar](5) NULL,
	[transporte] [varchar](100) NULL,
	[rfc] [varchar](20) NULL,
	[curp] [varchar](20) NULL,
	[domicilio] [varchar](1000) NULL,
	[candado] [varchar](50) NULL,
	[pedimento_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_transportes] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
