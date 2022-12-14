/****** Object:  Table [dbo].[coves]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[coves](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[eDocuments] [varchar](50) NULL,
	[tipoOperacion] [varchar](50) NULL,
	[numeroFacturaRelacion] [varchar](50) NULL,
	[relacionFacturas] [varchar](50) NULL,
	[automotriz] [varchar](50) NULL,
	[fechaExpedicion] [date] NULL,
	[tipoFigura] [varchar](50) NULL,
	[observaciones] [varchar](1000) NULL,
	[pedimento_id] [int] NULL,
	[licencia] [int] NULL,
	[emisor] [int] NULL,
	[destinatario] [int] NULL,
	[adenda] [varchar](50) NULL,
 CONSTRAINT [PK_coves] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
